<?php

declare(strict_types=1);

use Streeboga\RussianId\Ogrn;

it('валидирует 13-значный ОГРН юрлица', function (): void {
    expect(Ogrn::isValid('1027700132195'))->toBeTrue();
});

it('валидирует 15-значный ОГРНИП', function (string $ogrnip): void {
    expect(Ogrn::isValid($ogrnip))->toBeTrue();
})->with([
    '304500116000157',
    '317746000000000',
]);

it('отклоняет ОГРН с битой контрольной цифрой', function (string $ogrn): void {
    expect(Ogrn::isValid($ogrn))->toBeFalse();
})->with([
    '1027700132194',
    '304500116000158',
]);

it('отклоняет неверную длину и вырожденные значения', function (string $ogrn): void {
    expect(Ogrn::isValid($ogrn))->toBeFalse();
})->with([
    '',
    '102770013219', // 12 цифр
    '10277001321951', // 14 цифр
    '0000000000000',
]);
