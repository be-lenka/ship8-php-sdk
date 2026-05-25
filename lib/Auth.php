<?php

namespace BeLenka\Ship8;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;

/**
 * Auth handles the Ship8 simplified-JWT authentication flow.
 *
 * Ship8 issues an access token in exchange for an account email + password
 * (POST /api/app/account/requestToken) and rotates it through a separate
 * refresh-token endpoint (POST /api/app/account/refreshToken). Both calls
 * share the same business host configured on the Configuration instance —
 * there is no dedicated identity-provider hostname.
 *
 * On success the resolved access token is stored on the linked Configuration
 * so subsequent Api clients pick it up via Authorization: Bearer headers.
 */
class Auth
{
    public const REQUEST_TOKEN_PATH = '/api/app/account/requestToken';
    public const REFRESH_TOKEN_PATH = '/api/app/account/refreshToken';

    /** @var string */
    private $email;

    /** @var string */
    private $password;

    /** @var Configuration */
    private $config;

    /** @var ClientInterface */
    private $client;

    /** @var string|null Latest refresh-token string returned by the IdP */
    private $refreshToken;

    /** @var \DateTimeInterface|null Access-token expiry */
    private $accessTokenExpireAt;

    /** @var \DateTimeInterface|null Refresh-token expiry */
    private $refreshTokenExpireAt;

    public function __construct(
        string $email,
        string $password,
        ?Configuration $config = null,
        ?ClientInterface $client = null
    ) {
        $this->email = $email;
        $this->password = $password;
        $this->config = $config ?: Configuration::getDefaultConfiguration();
        $this->client = $client ?: new Client();
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }

    public function getAccessTokenExpireAt(): ?\DateTimeInterface
    {
        return $this->accessTokenExpireAt;
    }

    public function getRefreshTokenExpireAt(): ?\DateTimeInterface
    {
        return $this->refreshTokenExpireAt;
    }

    /**
     * Exchange the configured email + password for an access token.
     *
     * @return string The resolved access token (also stored on Configuration)
     *
     * @throws Exception on any IdP / transport error
     */
    public function authenticate(): string
    {
        if ($this->email === '' || $this->password === '') {
            throw new Exception('Ship8 Auth requires an account email and password.');
        }

        $payload = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        $data = $this->send(self::REQUEST_TOKEN_PATH, $payload);
        return $this->applyTokenPayload($data);
    }

    /**
     * Trade an existing access + refresh token pair for a fresh access token.
     *
     * If $accessToken / $refreshToken are not provided, the values currently
     * held by this Auth instance (and Configuration) are used.
     *
     * @throws Exception
     */
    public function refresh(?string $accessToken = null, ?string $refreshToken = null): string
    {
        $accessToken = $accessToken ?? $this->config->getAccessToken();
        $refreshToken = $refreshToken ?? $this->refreshToken;

        if ($accessToken === '' || $refreshToken === null || $refreshToken === '') {
            throw new Exception('Ship8 refresh requires both an access token and a refresh token.');
        }

        $payload = [
            'accessToken' => $accessToken,
            'refreshToken' => $refreshToken,
        ];

        $data = $this->send(self::REFRESH_TOKEN_PATH, $payload);
        return $this->applyTokenPayload($data);
    }

    /**
     * @param array<string, string> $payload
     *
     * @return array<string, mixed> The unwrapped `data` envelope (Account.JwtTokenResultDto)
     *
     * @throws Exception
     */
    private function send(string $path, array $payload): array
    {
        $body = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        if ($body === false) {
            throw new Exception('Failed to JSON-encode auth payload: ' . json_last_error_msg());
        }

        $url = rtrim($this->config->getHost(), '/') . $path;
        $request = new Request(
            'POST',
            $url,
            [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'User-Agent' => $this->config->getUserAgent(),
            ],
            $body
        );

        try {
            $response = $this->client->send($request, $this->createHttpClientOption());
        } catch (RequestException $e) {
            throw new Exception('Ship8 auth request failed: ' . $e->getMessage(), (int) $e->getCode(), $e);
        } catch (ConnectException $e) {
            throw new Exception('Ship8 auth connection failed: ' . $e->getMessage(), (int) $e->getCode(), $e);
        }

        if ($response->getStatusCode() !== 200) {
            throw new Exception(
                'Failed to authenticate with Ship8. Status code: ' . $response->getStatusCode()
                . ' body: ' . (string) $response->getBody()
            );
        }

        $decoded = json_decode((string) $response->getBody(), true);
        if (!is_array($decoded)) {
            throw new Exception('Ship8 auth response was not a JSON object.');
        }

        if (isset($decoded['successful']) && $decoded['successful'] === false) {
            $code = $decoded['code'] ?? '';
            $message = $decoded['message'] ?? 'Unknown business error';
            throw new Exception(sprintf('Ship8 auth rejected the request: [%s] %s', $code, $message));
        }

        $data = $decoded['data'] ?? null;
        if (!is_array($data) || !isset($data['accessToken']) || !is_string($data['accessToken'])) {
            throw new Exception('Access token missing from Ship8 auth response.');
        }

        return $data;
    }

    /**
     * Persist the parsed JwtTokenResultDto onto Configuration + this instance.
     *
     * @param array<string, mixed> $data
     */
    private function applyTokenPayload(array $data): string
    {
        $accessToken = (string) $data['accessToken'];
        $this->config->setAccessToken($accessToken);

        $this->accessTokenExpireAt = $this->parseDate($data['accessTokenExpireAt'] ?? null);

        $refresh = $data['refreshToken'] ?? null;
        if (is_array($refresh)) {
            if (isset($refresh['tokenString']) && is_string($refresh['tokenString'])) {
                $this->refreshToken = $refresh['tokenString'];
            }
            $this->refreshTokenExpireAt = $this->parseDate($refresh['expireAt'] ?? null);
        }

        return $accessToken;
    }

    /**
     * @param mixed $value
     */
    private function parseDate($value): ?\DateTimeInterface
    {
        if (!is_string($value) || $value === '') {
            return null;
        }
        try {
            return new \DateTimeImmutable($value);
        } catch (\Exception $_) {
            return null;
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function createHttpClientOption(): array
    {
        $options = [];
        if ($this->config->getDebug()) {
            $handle = fopen($this->config->getDebugFile(), 'a');
            if ($handle === false) {
                throw new \RuntimeException('Failed to open the debug file: ' . $this->config->getDebugFile());
            }
            $options[RequestOptions::DEBUG] = $handle;
        }
        return $options;
    }
}
