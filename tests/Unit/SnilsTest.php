<?php

declare(strict_types=1);

use Streeboga\RussianId\Snils;

it('валидирует СНИЛС в каноническом формате', function (): void {
    expect(Snils::isValid('112-233-445 95'))->toBeTrue();
});

it('валидирует СНИЛС без разделителей', function (): void {
    expect(Snils::isValid('11223344595'))->toBeTrue();
});

it('отклоняет СНИЛС с битой контрольной суммой', function (): void {
    expect(Snils::isValid('112-233-445 96'))->toBeFalse();
});

it('отклоняет неверную длину и вырожденные значения', function (string $snils): void {
    expect(Snils::isValid($snils))->toBeFalse();
})->with([
    '',
    '1122334459', // 10 цифр
    '112233445951', // 12 цифр
    '00000000000',
]);
