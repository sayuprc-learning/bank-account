<?php

declare(strict_types=1);

namespace Tests\Unit\BankAccount\Domain;

use BankAccount\Domain\AccountNumber;
use Exception;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AccountNumberTest extends TestCase
{
    #[Test]
    #[DataProvider('validData')]
    public function インスタンス化できる(string $value): void
    {
        $accountNumber = new AccountNumber($value);

        $this->assertSame($value, $accountNumber->value);
    }

    public static function validData(): array
    {
        return [
            ['01234567'],
            ['12345678'],
        ];
    }

    #[Test]
    #[DataProvider('invalidData')]
    public function インスタンス化で例外が投げられる(string $value): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('口座番号は 8 桁で入力してください');

        new AccountNumber($value);
    }

    public static function invalidData(): array
    {
        return [
            [''],
            ['1234567'],
            ['123456789'],
            ['あいうえおかきく'],
            ['aiueokak'],
        ];
    }
}
