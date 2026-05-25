<?php
/**
 * InboundPOApi
 *
 * @category Class
 * @package  BeLenka\Ship8\Api
 */

namespace BeLenka\Ship8\Api;

use BeLenka\Ship8\ApiException;
use BeLenka\Ship8\Model\InboundPOCreationDto;
use BeLenka\Ship8\Model\InboundPOOutDto;

/**
 * InboundPOApi exposes the /api/app/inboundPO endpoints — purchase
 * orders sent *into* a Ship8 warehouse.
 */
class InboundPOApi extends AbstractApi
{
    /**
     * POST /api/app/inboundPO/create
     *
     * @throws ApiException
     */
    public function create(InboundPOCreationDto $po): InboundPOOutDto
    {
        return $this->request(
            'POST',
            '/api/app/inboundPO/create',
            [],
            [],
            $po,
            '\\BeLenka\\Ship8\\Model\\InboundPOOutDto'
        );
    }

    /**
     * POST /api/app/inboundPO/createEECBondedDC — variant for the
     * EEC bonded DC flow (links the PO to an EEC shipment via
     * `eecShipmentID` / `eecMasterPO_ID`).
     *
     * @throws ApiException
     */
    public function createEECBondedDC(InboundPOCreationDto $po): InboundPOOutDto
    {
        return $this->request(
            'POST',
            '/api/app/inboundPO/createEECBondedDC',
            [],
            [],
            $po,
            '\\BeLenka\\Ship8\\Model\\InboundPOOutDto'
        );
    }
}
