<?php

declare(strict_types=1);

use Streeboga\RussianId\Oms;

it('валидирует 16-значный ЕНП с корректной Luhn-цифрой', function (): void {
    expect(Oms::isValid('1234567890123452'))->toBeTrue();
});

it('принимает отформатированный вход', function (): void {
    expect(Oms::isValid('1234 5678 9012 3452'))->toBeTrue();
});

it('отклоняет ЕНП с битой контрольной цифрой', function (): void {
    expect(Oms::isValid('1234567890123453'))->toBeFalse();
});

it('отклоняет неверную длину и вырожденные значения', function (string $oms): void {
    expect(Oms::isValid($oms))->toBeFalse();
})->with([
    '',
    '123456789012345', // 15 цифр
    '12345678901234521', // 17 цифр
    '0000000000000000',
]);
