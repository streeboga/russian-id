<?php

declare(strict_types=1);

namespace Streeboga\RussianId;

/**
 * ИНН: 10 цифр (юрлица, одна контрольная) или 12 цифр (физлица/ИП,
 * две контрольные). Контрольное число = взвешенная сумма mod 11 mod 10.
 */
final readonly class Inn
{
    private const WEIGHTS_10 = [2, 4, 10, 3, 5, 9, 4, 6, 8];

    private const WEIGHTS_11 = [7, 2, 4, 10, 3, 5, 9, 4, 6, 8];

    private const WEIGHTS_12 = [3, 7, 2, 4, 10, 3, 5, 9, 4, 6, 8];

    public static function isValid(string $value): bool
    {
        $digits = Digits::extract($value);

        if (Digits::isDegenerate($digits)) {
            return false;
        }

        return match (strlen($digits)) {
            10 => self::checkDigit($digits, self::WEIGHTS_10) === (int) $digits[9],
            12 => self::checkDigit($digits, self::WEIGHTS_11) === (int) $digits[10]
                && self::checkDigit($digits, self::WEIGHTS_12) === (int) $digits[11],
            default => false,
        };
    }

    /**
     * @param  list<int>  $weights
     */
    private static function checkDigit(string $digits, array $weights): int
    {
        $sum = 0;
        foreach ($weights as $i => $weight) {
            $sum += $weight * (int) $digits[$i];
        }

        return $sum % 11 % 10;
    }
}
