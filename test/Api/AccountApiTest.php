<?php

namespace BeLenka\Ship8\Test\Api;

use BeLenka\Ship8\Api\AccountApi;
use BeLenka\Ship8\Configuration;
use BeLenka\Ship8\Model\JwtTokenResultDto;
use BeLenka\Ship8\Model\UserLoginDto;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class AccountApiTest extends TestCase
{
    public function testRequestTokenDeserializesNestedRefreshToken(): void
    {
        $payload = [
            'successful' => true,
            'data' => [
                'accessToken' => 'jwt',
                'accessTokenExpireAt' => '2026-05-08T12:00:00+00:00',
                'refreshToken' => [
                    'userName' => 'sandbox@example.com',
                    'tokenString' => 'rs',
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
        $login = (new UserLoginDto())->setEmail('sandbox@example.com')->setPassword('secret');

        $result = (new AccountApi($http, $config))->requestToken($login);

        self::assertInstanceOf(JwtTokenResultDto::class, $result);
        self::assertSame('jwt', $result->getAccessToken());
        self::assertNotNull($result->getRefreshToken());
        self::assertSame('rs', $result->getRefreshToken()->getTokenString());
        self::assertInstanceOf(\DateTimeInterface::class, $result->getAccessTokenExpireAt());

        /** @var RequestInterface $req */
        $req = $container[0]['request'];
        self::assertSame(
            'https://sandbox.ship8.com/api/app/account/requestToken',
            (string) $req->getUri()
        );
        $body = json_decode((string) $req->getBody(), true);
        self::assertSame(['email' => 'sandbox@example.com', 'password' => 'secret'], $body);
    }
}
