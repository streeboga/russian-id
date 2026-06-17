<?php

declare(strict_types=1);

namespace Streeboga\RussianId;

/**
 * Полис ОМС (ЕНП): 16 цифр, последняя — контрольная по алгоритму Луна
 * (как у банковских карт).
 */
final readonly class Oms
{
    public static function isValid(string $value): bool
    {
        $digits = Digits::extract($value);

        if (strlen($digits) !== 16 || Digits::isDegenerate($digits)) {
            return false;
        }

        return self::passesLuhn($digits);
    }

    private static function passesLuhn(string $digits): bool
    {
        $sum = 0;
        $alt = false;
        for ($i = strlen($digits) - 1; $i >= 0; $i--) {
            $d = (int) $digits[$i];
            if ($alt) {
                $d *= 2;
                if ($d > 9) {
                    $d -= 9;
                }
            }
            $sum += $d;
            $alt = ! $alt;
        }

        return $sum % 10 === 0;
    }
}
