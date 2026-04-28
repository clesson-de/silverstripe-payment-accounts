<?php

declare(strict_types=1);

namespace Clesson\Silverstripe\PaymentAccount\Constants;

/**
 * Constants for online payment account providers.
 *
 * @package Clesson\Silverstripe\PaymentAccount
 * @subpackage Constants
 */
class OnlineAccountProvider
{

    /** @var string PayPal */
    public const PAYPAL = 'paypal';

    /** @var string Stripe */
    public const STRIPE = 'stripe';

    /** @var string Klarna */
    public const KLARNA = 'klarna';

    /** @var string Apple Pay */
    public const APPLE_PAY = 'apple_pay';

    /** @var string Google Pay */
    public const GOOGLE_PAY = 'google_pay';

    /** @var string Other */
    public const OTHER = 'other';

    /**
     * Returns all providers as an associative array for use in dropdowns.
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        return [
            self::PAYPAL     => _t(__CLASS__ . '.PAYPAL', 'PayPal'),
            self::STRIPE     => _t(__CLASS__ . '.STRIPE', 'Stripe'),
            self::KLARNA     => _t(__CLASS__ . '.KLARNA', 'Klarna'),
            self::APPLE_PAY  => _t(__CLASS__ . '.APPLE_PAY', 'Apple Pay'),
            self::GOOGLE_PAY => _t(__CLASS__ . '.GOOGLE_PAY', 'Google Pay'),
            self::OTHER      => _t(__CLASS__ . '.OTHER', 'Other'),
        ];
    }

    /**
     * Returns the translated label for a given provider value.
     *
     * @param mixed $value
     * @return string
     */
    public static function label(mixed $value): string
    {
        $options = self::options();
        return isset($options[$value]) ? $options[$value] : (string)$value;
    }

}

