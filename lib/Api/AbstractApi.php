<?php
/**
 * AbstractApi
 *
 * @category Class
 * @package  BeLenka\Ship8\Api
 */

namespace BeLenka\Ship8\Api;

use BeLenka\Ship8\ApiException;
use BeLenka\Ship8\Configuration;
use BeLenka\Ship8\HeaderSelector;
use BeLenka\Ship8\ObjectSerializer;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

/**
 * AbstractApi centralises the request/response plumbing that every concrete
 * Ship8 API class (OrderApi, ShipmentApi, ProductApi, ...) needs:
 *
 *   - request building (path + query + headers + body)
 *   - sending via Guzzle with consistent error mapping to ApiException
 *   - response deserialization through ObjectSerializer
 *   - unwrapping of the Ship8 ResultDto envelope { successful, code, message, data }
 *
 * Ship8 wraps every business response in ResultDto. A 200 response with
 * `successful=false` is still a business error: the envelope is unwrapped
 * by default and a non-successful payload raises ApiException carrying the
 * server's `code` / `message`.
 */
abstract class AbstractApi
{
    /** @var ClientInterface */
    protected $client;

    /** @var Configuration */
    protected $config;

    /** @var HeaderSelector */
    protected $headerSelector;

    public function __construct(
        ?ClientInterface $client = null,
        ?Configuration $config = null,
        ?HeaderSelector $selector = null
    ) {
        $this->client = $client ?: new Client();
        $this->config = $config ?: Configuration::getDefaultConfiguration();
        $this->headerSelector = $selector ?: new HeaderSelector();
    }

    public function getConfig(): Configuration
    {
        return $this->config;
    }

    /**
     * Send a request and return the deserialized body.
     *
     * @param string                       $method      HTTP verb
     * @param string                       $path        Path relative to Configuration::getHost(),
     *                                                  with `{name}` placeholders already substituted
     * @param array<string, mixed>         $query       Query parameters (null values stripped)
     * @param array<string, string>        $headers     Extra request headers
     * @param mixed                        $body        Request body (will be JSON-encoded if not a string)
     * @param string                       $returnType  Target type for ObjectSerializer::deserialize
     * @param string[]                     $accept      Acceptable response content types
     * @param string                       $contentType Request body content type
     * @param bool                         $unwrapResult  When true (default) the Ship8 ResultDto envelope
     *                                                    is parsed and only `data` is deserialized into
     *                                                    `$returnType`. When false the raw payload is
     *                                                    deserialized.
     *
     * @return mixed Deserialized response body
     *
     * @throws ApiException
     */
    protected function request(
        string $method,
        string $path,
        array $query = [],
        array $headers = [],
        $body = null,
        string $returnType = 'mixed',
        array $accept = ['application/json'],
        string $contentType = 'application/json',
        bool $unwrapResult = true
    ) {
        $request = $this->buildRequest($method, $path, $query, $headers, $body, $accept, $contentType);

        try {
            $response = $this->client->send($request, $this->createHttpClientOption());
        } catch (RequestException $e) {
            throw new ApiException(
                sprintf('[%d] %s', (int) $e->getCode(), $e->getMessage()),
                (int) $e->getCode(),
                $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                $e->getResponse() ? (string) $e->getResponse()->getBody() : null
            );
        } catch (ConnectException $e) {
            throw new ApiException(
                sprintf('[%d] %s', (int) $e->getCode(), $e->getMessage()),
                (int) $e->getCode(),
                null,
                null
            );
        }

        return $this->deserializeResponse($request, $response, $returnType, $unwrapResult);
    }

    /**
     * @param array<string, mixed>  $query
     * @param array<string, string> $headers
     * @param mixed                 $body
     * @param string[]              $accept
     */
    protected function buildRequest(
        string $method,
        string $path,
        array $query,
        array $headers,
        $body,
        array $accept,
        string $contentType
    ): Request {
        $resolvedHeaders = array_merge(
            $this->headerSelector->selectHeaders($accept, $contentType, false),
            $this->authHeaders(),
            ['User-Agent' => $this->config->getUserAgent()],
            $headers
        );

        $url = rtrim($this->config->getHost(), '/') . '/' . ltrim($path, '/');
        $queryString = ObjectSerializer::buildQuery($query);
        if ($queryString !== '') {
            $url .= (strpos($url, '?') === false ? '?' : '&') . $queryString;
        }

        $httpBody = null;
        if ($body !== null) {
            if (is_string($body)) {
                $httpBody = $body;
            } else {
                $httpBody = json_encode(
                    ObjectSerializer::sanitizeForSerialization($body),
                    JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
                );
                if ($httpBody === false) {
                    throw new ApiException('Failed to JSON-encode request body: ' . json_last_error_msg());
                }
            }
        }

        return new Request($method, $url, $resolvedHeaders, $httpBody);
    }

    /**
     * @return mixed
     *
     * @throws ApiException
     */
    protected function deserializeResponse(
        Request $request,
        ResponseInterface $response,
        string $returnType,
        bool $unwrapResult = true
    ) {
        $statusCode = $response->getStatusCode();

        if ($statusCode < 200 || $statusCode > 299) {
            throw new ApiException(
                sprintf('[%d] Error connecting to the API (%s)', $statusCode, (string) $request->getUri()),
                $statusCode,
                $response->getHeaders(),
                (string) $response->getBody()
            );
        }

        if ($returnType === 'void' || $statusCode === 204) {
            return null;
        }

        $rawBody = (string) $response->getBody();
        if ($returnType === 'string') {
            return $rawBody;
        }

        if ($rawBody === '') {
            return null;
        }

        try {
            $decoded = json_decode($rawBody, false, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new ApiException(
                sprintf('Error JSON decoding server response (%s)', $request->getUri()),
                $statusCode,
                $response->getHeaders(),
                $rawBody
            );
        }

        if ($unwrapResult && is_object($decoded) && property_exists($decoded, 'successful')) {
            if ($decoded->successful !== true) {
                $code = isset($decoded->code) ? (string) $decoded->code : '';
                $message = isset($decoded->message) ? (string) $decoded->message : 'Ship8 returned a business error.';
                throw new ApiException(
                    sprintf('[%s] %s', $code, $message),
                    $statusCode,
                    $response->getHeaders(),
                    $rawBody
                );
            }
            $decoded = $decoded->data ?? null;
            if ($decoded === null) {
                return null;
            }
        }

        return ObjectSerializer::deserialize($decoded, $returnType, $response->getHeaders());
    }

    /**
     * Build the Authorization headers based on Configuration. Ship8 uses
     * Bearer JWTs; Basic auth is kept as a fallback so the SDK stays usable
     * for any future endpoint that might expect it.
     *
     * @return array<string, string>
     */
    protected function authHeaders(): array
    {
        $headers = [];
        $token = $this->config->getAccessToken();
        if ($token !== '') {
            $headers['Authorization'] = 'Bearer ' . $token;
            return $headers;
        }

        if ($this->config->getUsername() !== '' || $this->config->getPassword() !== '') {
            $headers['Authorization'] = 'Basic ' . base64_encode(
                $this->config->getUsername() . ':' . $this->config->getPassword()
            );
        }
        return $headers;
    }

    /**
     * @return array<string, mixed>
     */
    protected function createHttpClientOption(): array
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
