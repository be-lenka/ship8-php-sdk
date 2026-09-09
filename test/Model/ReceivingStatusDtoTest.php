<?php

namespace BeLenka\Ship8\Test\Model;

use BeLenka\Ship8\Model\ReceivingItemStatusDto;
use BeLenka\Ship8\Model\ReceivingStatusDto;
use BeLenka\Ship8\ObjectSerializer;
use PHPUnit\Framework\TestCase;

class ReceivingStatusDtoTest extends TestCase
{
    /**
     * @param array<string, mixed> $wire
     */
    private function deserialize(array $wire): ReceivingStatusDto
    {
        return ObjectSerializer::deserialize(
            json_decode(json_encode($wire), false),
            '\\BeLenka\\Ship8\\Model\\ReceivingStatusDto',
            []
        );
    }

    public function testDeserializeCoercesQuantitiesToFloat(): void
    {
        // note the wire values are JSON ints, not floats — Ship8 sends whole
        // numbers unquoted and the spec declares them number/double
        $dto = $this->deserialize([
            'receivingOrder' => 'RO-1001',
            'customerCode' => 'ACME',
            'receivingStatus' => 'Receiving',
            'items' => [
                [
                    'itemNo' => 'SKU-1',
                    'itemUPC' => '0123456789012',
                    'expectedQty' => 10,
                    'receivedQty' => 7,
                    'varianceQty' => 3,
                    'itemStatus' => 'Open',
                ],
            ],
        ]);

        self::assertInstanceOf(ReceivingStatusDto::class, $dto);
        self::assertCount(1, $dto->getItems());

        $item = $dto->getItems()[0];
        self::assertInstanceOf(ReceivingItemStatusDto::class, $item);
        self::assertIsFloat($item->getExpectedQty());
        self::assertIsFloat($item->getReceivedQty());
        self::assertIsFloat($item->getVarianceQty());
        self::assertSame(10.0, $item->getExpectedQty());
        self::assertSame(7.0, $item->getReceivedQty());
        // Variance = expected - received; positive means short received
        self::assertSame(3.0, $item->getVarianceQty());
    }

    public function testDeserializeParsesDateTimeFields(): void
    {
        $dto = $this->deserialize([
            'receivingOrder' => 'RO-1001',
            'shipDate' => '2026-08-01T00:00:00+00:00',
            'estimatedDeliveryDate' => '2026-08-10T12:30:00+00:00',
        ]);

        self::assertInstanceOf(\DateTimeInterface::class, $dto->getShipDate());
        self::assertInstanceOf(\DateTimeInterface::class, $dto->getEstimatedDeliveryDate());
        self::assertSame('2026-08-01', $dto->getShipDate()->format('Y-m-d'));
        self::assertSame('2026-08-10 12:30', $dto->getEstimatedDeliveryDate()->format('Y-m-d H:i'));
    }

    public function testRoundTripPreservesAllCapsWireKeys(): void
    {
        $dto = $this->deserialize([
            'receivingOrder' => 'RO-1001',
            'carrierSCAC' => 'FDEG',
            'items' => [
                [
                    'itemNo' => 'SKU-1',
                    'itemUPC' => '0123456789012',
                    'expectedQty' => 10,
                    'receivedQty' => 10,
                    'varianceQty' => 0,
                    'itemStatus' => 'Received',
                ],
            ],
        ]);

        $payload = json_decode(json_encode(ObjectSerializer::sanitizeForSerialization($dto)), true);

        // Receiving/InboundPO/ReleaseSO use itemUPC; ReturnOrders uses itemUpc.
        // The wire key IS the property name (attributeMap is identity-derived),
        // so a casing drift here would silently drop the field.
        self::assertArrayHasKey('itemUPC', $payload['items'][0]);
        self::assertArrayNotHasKey('itemUpc', $payload['items'][0]);
        self::assertSame('0123456789012', $payload['items'][0]['itemUPC']);

        self::assertArrayHasKey('carrierSCAC', $payload);
        self::assertSame('FDEG', $payload['carrierSCAC']);
    }

    public function testHasPropertyReportsSchemaProperties(): void
    {
        $dto = new ReceivingStatusDto();

        // hasProperty() is the CLAUDE.md-sanctioned check — method_exists()
        // cannot see accessors dispatched through AbstractModel::__call()
        self::assertTrue($dto->hasProperty('items'));
        self::assertTrue($dto->hasProperty('carrierSCAC'));
        self::assertTrue($dto->hasProperty('receivingStatus'));
        self::assertFalse($dto->hasProperty('receivingLines'));
        self::assertFalse($dto->hasProperty('nonExistent'));

        self::assertTrue((new ReceivingItemStatusDto())->hasProperty('itemUPC'));
        self::assertFalse((new ReceivingItemStatusDto())->hasProperty('itemUpc'));
    }

    /**
     * The three wire shapes `items` can arrive in. Absent and explicit-null
     * both yield null, so consumers must write `getItems() ?? []`.
     *
     * @dataProvider itemsWireShapeProvider
     *
     * @param array<string, mixed>  $wire
     * @param array<int, mixed>|null $expected
     */
    public function testItemsWireShapes(array $wire, ?array $expected): void
    {
        self::assertSame($expected, $this->deserialize($wire)->getItems());
    }

    /**
     * @return array<string, array{0: array<string, mixed>, 1: array<int, mixed>|null}>
     */
    public function itemsWireShapeProvider(): array
    {
        return [
            'key absent' => [['receivingOrder' => 'RO-1'], null],
            'explicit null' => [['receivingOrder' => 'RO-1', 'items' => null], null],
            'empty array' => [['receivingOrder' => 'RO-1', 'items' => []], []],
        ];
    }

    public function testUnsetPropertiesReadAsNull(): void
    {
        // AbstractModel seeds every property to null, so a caller can always
        // observe null even for spec-non-nullable fields
        $dto = new ReceivingStatusDto();

        self::assertNull($dto->getReceivingOrder());
        self::assertNull($dto->getShipDate());
        self::assertNull($dto->getItems());
        self::assertSame('Receivings.Dtos.ReceivingStatusDto', $dto->getModelName());
        self::assertSame('Receivings.Dtos.ReceivingItemStatusDto', (new ReceivingItemStatusDto())->getModelName());
    }
}
