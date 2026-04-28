<?php

declare(strict_types=1);

namespace Clesson\Silverstripe\PaymentAccount\Constants;

/**
 * Constants for credit card types.
 *
 * @package Clesson\Silverstripe\PaymentAccount
 * @subpackage Constants
 */
class CreditCardType
{

    /** @var string Visa */
    public const VISA = 'visa';

    /** @var string Mastercard */
    public const MASTERCARD = 'mastercard';

    /** @var string American Express */
    public const AMEX = 'amex';

    /** @var string Diners Club */
    public const DINERS = 'diners';

    /** @var string Other */
    public const OTHER = 'other';

    /**
     * Returns all credit card types as an associative array for use in dropdowns.
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        return [
            self::VISA       => _t(__CLASS__ . '.VISA', 'Visa'),
            self::MASTERCARD => _t(__CLASS__ . '.MASTERCARD', 'Mastercard'),
            self::AMEX       => _t(__CLASS__ . '.AMEX', 'American Express'),
            self::DINERS     => _t(__CLASS__ . '.DINERS', 'Diners Club'),
            self::OTHER      => _t(__CLASS__ . '.OTHER', 'Other'),
        ];
    }

    /**
     * Returns the translated label for a given credit card type value.
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

