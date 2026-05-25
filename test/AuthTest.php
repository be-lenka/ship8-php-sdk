<?php

namespace BeLenka\Ship8\Test;

use BeLenka\Ship8\Auth;
use BeLenka\Ship8\Configuration;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class AuthTest extends TestCase
{
    public function testRequestTokenSendsJsonAndStoresAccessToken(): void
    {
        $payload = [
            'successful' => true,
            'code' => '200',
            'message' => 'OK',
            'data' => [
                'accessToken' => 'fresh-jwt',
                'accessTokenExpireAt' => '2026-05-08T12:00:00+00:00',
                'refreshToken' => [
                    'userName' => 'sandbox@example.com',
                    'tokenString' => 'refresh-string',
                    'expireAt' => '2026-06-01T12:00:00+00:00',
                ],
            ],
        ];

        $container = [];
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], json_encode($payload)),
        ]);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($container));
        $http = new Client(['handler' => $stack]);

        $config = (new Configuration())->setHost('https://sandbox.ship8.com');
        $auth = new Auth('sandbox@example.com', 'secret', $config, $http);

        $token = $auth->authenticate();

        self::assertSame('fresh-jwt', $token);
        self::assertSame('fresh-jwt', $config->getAccessToken());
        self::assertSame('refresh-string', $auth->getRefreshToken());
        self::assertNotNull($auth->getAccessTokenExpireAt());
        self::assertNotNull($auth->getRefreshTokenExpireAt());

        self::assertCount(1, $container);
        /** @var RequestInterface $req */
        $req = $container[0]['request'];
        self::assertSame('POST', $req->getMethod());
        self::assertSame(
            'https://sandbox.ship8.com/api/app/account/requestToken',
            (string) $req->getUri()
        );
        self::assertSame('application/json', $req->getHeaderLine('Content-Type'));

        $body = json_decode((string) $req->getBody(), true);
        self::assertSame(['email' => 'sandbox@example.com', 'password' => 'secret'], $body);
    }

    public function testRefreshSendsAccessAndRefreshTokens(): void
    {
        $payload = [
            'successful' => true,
            'data' => [
                'accessToken' => 'rotated-jwt',
                'accessTokenExpireAt' => '2026-05-08T13:00:00+00:00',
                'refreshToken' => [
                    'tokenString' => 'rotated-refresh',
                    'expireAt' => '2026-06-01T13:00:00+00:00',
                ],
            ],
        ];

        $container = [];
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], json_encode($payload)),
        ]);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($container));
        $http = new Client(['handler' => $stack]);

        $config = (new Configuration())
            ->setHost('https://sandbox.ship8.com')
            ->setAccessToken('expired-jwt');
        $auth = new Auth('sandbox@example.com', 'secret', $config, $http);

        $token = $auth->refresh('expired-jwt', 'old-refresh');

        self::assertSame('rotated-jwt', $token);
        self::assertSame('rotated-jwt', $config->getAccessToken());
        self::assertSame('rotated-refresh', $auth->getRefreshToken());

        $req = $container[0]['request'];
        self::assertSame('POST', $req->getMethod());
        self::assertSame(
            'https://sandbox.ship8.com/api/app/account/refreshToken',
            (string) $req->getUri()
        );
        $body = json_decode((string) $req->getBody(), true);
        self::assertSame(
            ['accessToken' => 'expired-jwt', 'refreshToken' => 'old-refresh'],
            $body
        );
    }

    public function testRequestTokenRaisesOnSuccessfulFalse(): void
    {
        $payload = [
            'successful' => false,
            'code' => 'AUTH_INVALID',
            'message' => 'Invalid credentials',
            'data' => null,
        ];
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], json_encode($payload)),
        ]);
        $http = new Client(['handler' => HandlerStack::create($mock)]);

        $auth = new Auth('user', 'pw', new Configuration(), $http);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessageMatches('/AUTH_INVALID/');
        $auth->authenticate();
    }

    public function testRequestTokenThrowsWhenAccessTokenMissing(): void
    {
        $payload = [
            'successful' => true,
            'data' => [],
        ];
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], json_encode($payload)),
        ]);
        $http = new Client(['handler' => HandlerStack::create($mock)]);

        $auth = new Auth('user', 'pw', new Configuration(), $http);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessageMatches('/Access token missing/');
        $auth->authenticate();
    }

    public function testAuthenticateRequiresEmailAndPassword(): void
    {
        $auth = new Auth('', '', new Configuration());
        $this->expectException(\Exception::class);
        $auth->authenticate();
    }
}
