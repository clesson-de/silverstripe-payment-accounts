<?php

declare(strict_types=1);

namespace Clesson\Silverstripe\PaymentAccount\Helpers;

/**
 * Provides IBAN validation according to ISO 13616.
 *
 * @package Clesson\Silverstripe\PaymentAccount
 * @subpackage Helpers
 */
class IbanHelper
{
    /**
     * Validates an IBAN string.
     *
     * Strips whitespace, converts to uppercase and checks:
     * - Minimum length of 15 characters
     * - Country code is two ASCII letters
     * - Check digits pass the MOD-97 algorithm
     *
     * @param string $iban The raw IBAN string (whitespace is ignored).
     * @return bool True if the IBAN is structurally valid.
     */
    public static function isValid(string $iban): bool
    {
        $iban = strtoupper(preg_replace('/\s+/', '', $iban));

        if (strlen($iban) < 15) {
            return false;
        }

        if (!ctype_alpha(substr($iban, 0, 2))) {
            return false;
        }

        $rearranged = substr($iban, 4) . substr($iban, 0, 4);

        $numeric = '';
        foreach (str_split($rearranged) as $char) {
            $numeric .= ctype_alpha($char) ? (string)(ord($char) - 55) : $char;
        }

        return self::mod97($numeric) === 1;
    }

    /**
     * Computes the MOD-97 remainder of a numeric string too large for standard integer arithmetic.
     *
     * @param string $numericString A string containing only digits.
     * @return int The remainder after division by 97.
     */
    private static function mod97(string $numericString): int
    {
        $remainder = 0;
        foreach (str_split($numericString, 9) as $chunk) {
            $remainder = (int)(($remainder . $chunk) % 97);
        }
        return $remainder;
    }
}

