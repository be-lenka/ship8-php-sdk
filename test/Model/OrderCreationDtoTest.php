<?php

namespace BeLenka\Ship8\Test\Model;

use BeLenka\Ship8\Model\OrderCreationDto;
use BeLenka\Ship8\Model\OrderItemCreationDto;
use BeLenka\Ship8\ObjectSerializer;
use PHPUnit\Framework\TestCase;

class OrderCreationDtoTest extends TestCase
{
    public function testListInvalidPropertiesFlagsMissingRequiredFields(): void
    {
        $dto = new OrderCreationDto();
        $errors = $dto->listInvalidProperties();

        self::assertNotEmpty($errors);
        self::assertContains("'customerCode' is required.", $errors);
        self::assertContains("'shipToLevel' is required.", $errors);
        self::assertContains("'orderItems' is required.", $errors);
        self::assertFalse($dto->valid());
    }

    public function testValidWhenAllRequiredFieldsSet(): void
    {
        $dto = (new OrderCreationDto())
            ->setCustomerCode('ACME')
            ->setCustomerOrderNo('SO-1')
            ->setCustomerOrderDate(new \DateTime('2026-05-01'))
            ->setCarrierSCACCode('FDEG')
            ->setCrossDocking(false)
            ->setShipToLevel(OrderCreationDto::SHIP_TO_LEVEL_CUSTOMER)
            ->setShipToCustomerName('Alice')
            ->setShipToAddressLine1('1 Main')
            ->setShipToCity('Austin')
            ->setShipToState('TX')
            ->setShipToZipCode('78701')
            ->setShipToCountry('US')
            ->setOrderItems([(new OrderItemCreationDto())->setItemNo('SKU-1')->setItemQty(5)]);

        self::assertTrue($dto->valid(), 'Expected listInvalidProperties to be empty but got: '
            . implode(', ', $dto->listInvalidProperties()));
    }

    public function testSanitizeForSerializationDropsNullsAndKeepsCamelCaseKeys(): void
    {
        $dto = (new OrderCreationDto())
            ->setCustomerCode('ACME')
            ->setCustomerOrderNo('SO-1')
            ->setCustomerOrderDate(new \DateTime('2026-05-01T00:00:00+00:00'))
            ->setCarrierSCACCode('FDEG')
            ->setCrossDocking(true)
            ->setShipToLevel(OrderCreationDto::SHIP_TO_LEVEL_CUSTOMER)
            ->setShipToCustomerName('Alice')
            ->setShipToAddressLine1('1 Main')
            ->setShipToCity('Austin')
            ->setShipToState('TX')
            ->setShipToZipCode('78701')
            ->setShipToCountry('US')
            ->setOrderItems([(new OrderItemCreationDto())->setItemNo('SKU-1')->setItemQty(5)]);

        $payload = json_decode(json_encode(ObjectSerializer::sanitizeForSerialization($dto)), true);

        self::assertSame('ACME', $payload['customerCode']);
        self::assertSame(true, $payload['crossDocking']);
        self::assertSame('Customer', $payload['shipToLevel']);
        self::assertArrayNotHasKey('cancelDate', $payload);
        self::assertArrayNotHasKey('businessLine', $payload);
        self::assertSame('2026-05-01T00:00:00+00:00', $payload['customerOrderDate']);
    }
}
