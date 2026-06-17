<?php

declare(strict_types=1);

namespace Streeboga\RussianId;

/**
 * Нормализация входа: валидаторы принимают как «голые» цифры, так и
 * отформатированные значения («112-233-445 95», «7707 083893»).
 */
final readonly class Digits
{
    public static function extract(string $value): string
    {
        return (string) preg_replace('/\D+/u', '', $value);
    }

    /**
     * Вырожденные последовательности («00000000000», «11111111111») формально
     * проходят контрольные суммы, но реальными идентификаторами не являются.
     */
    public static function isDegenerate(string $digits): bool
    {
        return $digits === '' || preg_match('/\A(\d)\1*\z/', $digits) === 1;
    }
}
