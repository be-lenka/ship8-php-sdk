<?php
/**
 * OrderStatusEnum
 *
 * @category Class
 * @package  BeLenka\Ship8\Model
 */

declare(strict_types=1);

namespace BeLenka\Ship8\Model;

/**
 * Canonical set of values returned in `OrderOutDto::status` (and used in
 * shipment lookups) by the Ship8 API.
 *
 * Confirmed by Ship8 partner support 2026-05-07: the only values an order
 * progresses through are `Pending`, `Open`, `Shipping`, `Shipped`,
 * `Cancelled`. Final states (no further transitions) are `Shipped` and
 * `Cancelled`.
 *
 * Note: Ship8 spells the cancelled state with double-l (UK). Consumers
 * comparing against literal strings should use these constants to avoid
 * silent mismatches against US-spelt 'Canceled'.
 */
final class OrderStatusEnum
{
    public const PENDING   = 'Pending';
    public const OPEN      = 'Open';
    public const SHIPPING  = 'Shipping';
    public const SHIPPED   = 'Shipped';
    public const CANCELLED = 'Cancelled';

    /** @var string[] */
    public const ALL = [
        self::PENDING,
        self::OPEN,
        self::SHIPPING,
        self::SHIPPED,
        self::CANCELLED,
    ];

    /**
     * Statuses that do not transition further — once an order reaches one
     * of these, polling can stop.
     *
     * @var string[]
     */
    public const FINAL_STATES = [
        self::SHIPPED,
        self::CANCELLED,
    ];

    public static function isFinal(?string $status): bool
    {
        return $status !== null && in_array($status, self::FINAL_STATES, true);
    }

    public static function isValid(?string $status): bool
    {
        return $status !== null && in_array($status, self::ALL, true);
    }
}
