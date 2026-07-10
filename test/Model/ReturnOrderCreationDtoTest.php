<?php

namespace BeLenka\Ship8\Test\Model;

use BeLenka\Ship8\Model\ReturnOrderCreationDto;
use BeLenka\Ship8\Model\ReturnOrderItemCreationDto;
use BeLenka\Ship8\ObjectSerializer;
use PHPUnit\Framework\TestCase;

class ReturnOrderCreationDtoTest extends TestCase
{
    public function testListInvalidPropertiesFlagsMissingRequiredFields(): void
    {
        $dto = new ReturnOrderCreationDto();
        $errors = $dto->listInvalidProperties();

        self::assertNotEmpty($errors);
        self::assertContains("'customerCode' is required.", $errors);
        self::assertContains("'returnOrderNo' is required.", $errors);
        self::assertContains("'returnDate' is required.", $errors);
        self::assertContains("'trackingNo' is required.", $errors);
        self::assertContains("'orderItems' is required.", $errors);
        self::assertFalse($dto->valid());
    }

    public function testValidWhenAllRequiredFieldsSet(): void
    {
        $dto = (new ReturnOrderCreationDto())
            ->setCustomerCode('ACME')
            ->setReturnOrderNo('RMA-1')
            ->setReturnDate(new \DateTime('2026-06-01'))
            ->setTrackingNo('1Z999AA10123456784')
            ->setOrderItems([
                (new ReturnOrderItemCreationDto())
                    ->setItemNo('SKU-1')
                    ->setItemUpc('0001234567890')
                    ->setItemQty(1),
            ]);

        self::assertTrue($dto->valid(), 'Expected listInvalidProperties to be empty but got: '
            . implode(', ', $dto->listInvalidProperties()));
    }

    public function testSanitizeForSerializationDropsNullsAndKeepsCamelCaseKeys(): void
    {
        $dto = (new ReturnOrderCreationDto())
            ->setCustomerCode('ACME')
            ->setReturnOrderNo('RMA-1')
            ->setReturnDate(new \DateTime('2026-06-01T09:30:00+00:00'))
            ->setTrackingNo('1Z999AA10123456784')
            ->setOrderItems([
                (new ReturnOrderItemCreationDto())
                    ->setItemNo('SKU-1')
                    ->setItemUpc('0001234567890')
                    ->setItemQty(3),
            ]);

        $payload = json_decode(json_encode(ObjectSerializer::sanitizeForSerialization($dto)), true);

        self::assertSame('ACME', $payload['customerCode']);
        self::assertSame('RMA-1', $payload['returnOrderNo']);
        self::assertSame('1Z999AA10123456784', $payload['trackingNo']);
        self::assertSame('2026-06-01T09:30:00+00:00', $payload['returnDate']);
        // optional fields left unset are dropped
        self::assertArrayNotHasKey('salesOrderNo', $payload);
        self::assertArrayNotHasKey('returnLoc', $payload);
        // nested items keep camelCase keys and drop their own nulls
        self::assertSame(
            [['itemNo' => 'SKU-1', 'itemUpc' => '0001234567890', 'itemQty' => 3]],
            $payload['orderItems']
        );
    }
}
