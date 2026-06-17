<?php

declare(strict_types=1);

namespace Streeboga\RussianId;

/**
 * СНИЛС: 9 цифр номера + 2 контрольные. Сумма первых девяти с весами 9..1,
 * контрольное число = sum mod 101 (100 → 0), сравнивается с последними двумя.
 */
final readonly class Snils
{
    public static function isValid(string $value): bool
    {
        $digits = Digits::extract($value);

        if (strlen($digits) !== 11 || Digits::isDegenerate($digits)) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += (int) $digits[$i] * (9 - $i);
        }

        $control = $sum % 101;
        if ($control === 100) {
            $control = 0;
        }

        return $control === (int) substr($digits, 9, 2);
    }
}
