<?php

declare(strict_types=1);

use Streeboga\RussianId\Inn;

it('валидирует 10-значный ИНН юрлица', function (): void {
    expect(Inn::isValid('7707083893'))->toBeTrue();
});

it('валидирует 12-значный ИНН физлица (две контрольные)', function (): void {
    expect(Inn::isValid('500100732259'))->toBeTrue();
});

it('принимает отформатированный вход', function (): void {
    expect(Inn::isValid('ИНН 7707 083893'))->toBeTrue();
});

it('отклоняет ИНН с битой контрольной цифрой', function (string $inn): void {
    expect(Inn::isValid($inn))->toBeFalse();
})->with([
    '7707083894', // 10 цифр, контрольная +1
    '500100732258', // 12 цифр, последняя контрольная битая
    '500100732159', // 12 цифр, первая контрольная битая
]);

it('отклоняет неверную длину и вырожденные значения', function (string $inn): void {
    expect(Inn::isValid($inn))->toBeFalse();
})->with([
    '',
    '770708389', // 9 цифр
    '77070838931', // 11 цифр
    '0000000000',
    '111111111111',
]);
