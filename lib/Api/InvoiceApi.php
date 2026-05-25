<?php
/**
 * InvoiceApi
 *
 * @category Class
 * @package  BeLenka\Ship8\Api
 */

namespace BeLenka\Ship8\Api;

use BeLenka\Ship8\ApiException;
use BeLenka\Ship8\Model\InvoiceOutDto;

/**
 * InvoiceApi exposes the /api/app/invoice endpoints.
 */
class InvoiceApi extends AbstractApi
{
    /**
     * GET /api/app/invoice/list
     *
     * @return InvoiceOutDto[]
     *
     * @throws ApiException
     */
    public function list(
        string $customerCode,
        \DateTimeInterface $invoiceDateStart,
        \DateTimeInterface $invoiceDateEnd,
        ?string $invoiceCategory = null
    ): array {
        $response = $this->request(
            'GET',
            '/api/app/invoice/list',
            [
                'CustomerCode' => $customerCode,
                'InvoiceDateStart' => $invoiceDateStart,
                'InvoiceDateEnd' => $invoiceDateEnd,
                'InvoiceCategory' => $invoiceCategory,
            ],
            [],
            null,
            '\\BeLenka\\Ship8\\Model\\InvoiceOutDto[]'
        );
        return $response ?? [];
    }
}
