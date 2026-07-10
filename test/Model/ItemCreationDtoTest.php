<?php

namespace BeLenka\Ship8\Test\Model;

use BeLenka\Ship8\Model\ItemCreationDto;
use BeLenka\Ship8\ObjectSerializer;
use PHPUnit\Framework\TestCase;

class ItemCreationDtoTest extends TestCase
{
    public function testUltraLightRoundTripsThroughSerialization(): void
    {
        self::assertSame('Yes', ItemCreationDto::ULTRA_LIGHT_YES);
        self::assertSame('No', ItemCreationDto::ULTRA_LIGHT_NO);

        $dto = (new ItemCreationDto())->setUltraLight(ItemCreationDto::ULTRA_LIGHT_YES);

        self::assertTrue($dto->hasProperty('ultraLight'));
        self::assertSame('Yes', $dto->getUltraLight());

        $payload = json_decode(json_encode(ObjectSerializer::sanitizeForSerialization($dto)), true);
        self::assertSame('Yes', $payload['ultraLight']);
    }

    public function testUltraLightDroppedFromWireWhenUnset(): void
    {
        $dto = (new ItemCreationDto())->setProductSKU('SKU-1');

        self::assertTrue($dto->hasProperty('ultraLight'));

        $payload = json_decode(json_encode(ObjectSerializer::sanitizeForSerialization($dto)), true);
        self::assertArrayNotHasKey('ultraLight', $payload);
    }
}
