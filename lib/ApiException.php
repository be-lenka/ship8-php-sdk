<?php
/**
 * ApiException
 *
 * @category Class
 * @package  BeLenka\Ship8
 */

namespace BeLenka\Ship8;

use Exception;

/**
 * ApiException is thrown for any non-2xx response, transport errors,
 * or malformed payloads returned by the Ship8 API.
 *
 * @category Class
 * @package  BeLenka\Ship8
 */
class ApiException extends Exception
{
    /**
     * The HTTP body of the server response either as JSON or string.
     *
     * @var \stdClass|string|null
     */
    protected $responseBody;

    /**
     * The HTTP headers of the server response.
     *
     * @var string[]|null
     */
    protected $responseHeaders;

    /**
     * The deserialized response object
     *
     * @var \stdClass|string|null
     */
    protected $responseObject;

    /**
     * @param string                $message         Error message
     * @param int                   $code            HTTP status code
     * @param string[]|null         $responseHeaders HTTP response headers
     * @param \stdClass|string|null $responseBody    HTTP body of the server response
     */
    public function __construct(string $message = '', int $code = 0, ?array $responseHeaders = [], $responseBody = null)
    {
        parent::__construct($message, $code);
        $this->responseHeaders = $responseHeaders;
        $this->responseBody = $responseBody;
    }

    public function getResponseHeaders(): ?array
    {
        return $this->responseHeaders;
    }

    /**
     * @return \stdClass|string|null
     */
    public function getResponseBody()
    {
        return $this->responseBody;
    }

    /**
     * @param mixed $obj
     */
    public function setResponseObject($obj): void
    {
        $this->responseObject = $obj;
    }

    /**
     * @return mixed
     */
    public function getResponseObject()
    {
        return $this->responseObject;
    }

    /**
     * Ship8 business error code from the response body, e.g. "500001".
     *
     * Reads both error shapes Ship8 returns: the 4xx `{"error": {"code", "message"}}`
     * body and the 2xx ResultDto `{"successful": false, "code", "message"}` envelope.
     * `getCode()` stays the HTTP status.
     */
    public function getErrorCode(): ?string
    {
        $error = $this->decodeError();
        return isset($error['code']) && $error['code'] !== '' ? (string) $error['code'] : null;
    }

    /**
     * Ship8 business error message from the response body (same shapes as getErrorCode()).
     */
    public function getErrorMessage(): ?string
    {
        $error = $this->decodeError();
        return isset($error['message']) ? (string) $error['message'] : null;
    }

    /**
     * @return array<string, mixed>|null
     */
    private function decodeError(): ?array
    {
        $body = $this->responseBody;
        if ($body instanceof \stdClass) {
            $body = json_encode($body);
        }
        if (!is_string($body) || $body === '') {
            return null;
        }

        $decoded = json_decode($body, true);
        if (!is_array($decoded)) {
            return null;
        }
        if (isset($decoded['error']) && is_array($decoded['error'])) {
            return $decoded['error'];
        }
        if (array_key_exists('successful', $decoded)) {
            return $decoded;
        }

        return null;
    }
}
