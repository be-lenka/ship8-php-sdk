<?php
/**
 * HeaderSelector
 *
 * @category Class
 * @package  BeLenka\Ship8
 */

namespace BeLenka\Ship8;

/**
 * HeaderSelector picks Accept / Content-Type headers for a given request.
 *
 * @category Class
 * @package  BeLenka\Ship8
 */
class HeaderSelector
{
    /**
     * @param string[] $accept       List of acceptable response media types
     * @param string   $contentType  Request body media type
     * @param bool     $isMultipart  True when body is multipart/form-data
     *
     * @return string[]
     */
    public function selectHeaders(array $accept, string $contentType, bool $isMultipart): array
    {
        $headers = [];

        $acceptHeader = $this->selectAcceptHeader($accept);
        if ($acceptHeader !== null) {
            $headers['Accept'] = $acceptHeader;
        }

        if (!$isMultipart) {
            if ($contentType === '') {
                $contentType = 'application/json';
            }
            $headers['Content-Type'] = $contentType;
        }

        return $headers;
    }

    private function selectAcceptHeader(array $accept): ?string
    {
        $accept = array_filter($accept);

        if (count($accept) === 0) {
            return null;
        }

        if (count($accept) === 1) {
            return reset($accept);
        }

        $headersWithJson = preg_grep('~(?i)^(application/json|[^;/ \t]+/[^;/ \t]+[+]json)[ \t]*(;.*)?$~', $accept);
        if (count($headersWithJson) === 0) {
            return implode(',', $accept);
        }

        // Prefer JSON variants by ordering them first
        $sorted = array_merge($headersWithJson, array_diff($accept, $headersWithJson));
        return implode(',', $sorted);
    }
}
