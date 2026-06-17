<?php

declare(strict_types=1);

namespace Streeboga\RussianId;

/**
 * ОГРН: 13 цифр (юрлица) — первые 12 mod 11 mod 10 = 13-я цифра.
 * ОГРНИП: 15 цифр (ИП) — первые 14 mod 13 mod 10 = 15-я цифра.
 */
final readonly class Ogrn
{
    public static function isValid(string $value): bool
    {
        $digits = Digits::extract($value);

        if (Digits::isDegenerate($digits)) {
            return false;
        }

        return match (strlen($digits)) {
            13 => self::checkDigit($digits, 12, 11) === (int) $digits[12],
            15 => self::checkDigit($digits, 14, 13) === (int) $digits[14],
            default => false,
        };
    }

    private static function checkDigit(string $digits, int $length, int $modulus): int
    {
        $body = (int) substr($digits, 0, $length);

        return $body % $modulus % 10;
    }
}
