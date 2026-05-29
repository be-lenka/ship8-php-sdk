<?php

namespace BeLenka\Ship8\Test\Model;

use BeLenka\Ship8\Model\InventoryDetailDto;
use BeLenka\Ship8\Model\InventoryDto;
use BeLenka\Ship8\Model\OrderOutDto;
use PHPUnit\Framework\TestCase;

/**
 * Regression coverage for AbstractModel::hasProperty().
 *
 * Reason this test exists: PHP's method_exists() ignores __call() magic
 * methods, so a consumer writing `method_exists($inv, 'getInventoryDetails')`
 * always gets false and silently drops the entire response. A real consumer
 * shipped exactly that bug for ~10 days (Venalio, 2026-05-29). hasProperty()
 * is the supported alternative — these tests pin the contract.
 */
class AbstractModelTest extends TestCase
{
    public function testHasPropertyReturnsTrueForDeclaredOpenApiProperty(): void
    {
        $inv = new InventoryDto();

        self::assertTrue($inv->hasProperty('customerCode'));
        self::assertTrue($inv->hasProperty('feedDate'));
        self::assertTrue($inv->hasProperty('inventoryDetails'));
    }

    public function testHasPropertyReturnsFalseForUnknownProperty(): void
    {
        $inv = new InventoryDto();

        self::assertFalse($inv->hasProperty('nope'));
        self::assertFalse($inv->hasProperty(''));
    }

    public function testHasPropertyIsCaseSensitive(): void
    {
        $inv = new InventoryDto();

        self::assertTrue($inv->hasProperty('inventoryDetails'));
        self::assertFalse($inv->hasProperty('InventoryDetails'));
        self::assertFalse($inv->hasProperty('inventorydetails'));
    }

    public function testMethodExistsIsFalseForGeneratedGettersDocumentingTheTrap(): void
    {
        // This assertion exists to document the trap that hasProperty()
        // exists to solve. If this ever flips to true, AbstractModel has
        // started declaring explicit getters and the CLAUDE.md warning can
        // be revisited.
        $inv = new InventoryDto();

        self::assertFalse(method_exists($inv, 'getInventoryDetails'));
        self::assertTrue(is_callable([$inv, 'getInventoryDetails']));
        self::assertTrue($inv->hasProperty('inventoryDetails'));
    }

    public function testHasPropertyWorksAcrossDifferentModelClasses(): void
    {
        // Sanity check: hasProperty resolves against the concrete subclass,
        // not the parent's cache. Two different models, two different
        // declared property sets — neither bleeds into the other.
        $inv = new InventoryDto();
        $detail = new InventoryDetailDto();
        $order = new OrderOutDto();

        self::assertTrue($inv->hasProperty('inventoryDetails'));
        self::assertFalse($detail->hasProperty('inventoryDetails'));
        self::assertFalse($order->hasProperty('inventoryDetails'));

        self::assertFalse($inv->hasProperty('itemNo'));
        self::assertTrue($detail->hasProperty('itemNo'));

        self::assertFalse($inv->hasProperty('orderItems'));
        self::assertTrue($order->hasProperty('orderItems'));
    }
}
