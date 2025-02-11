<?php

declare(strict_types=1);

namespace Tests\Unit\BankAccount\Domain;

use BankAccount\Domain\AccountNumber;
use BankAccount\Domain\Balance;
use BankAccount\Domain\BankAccount;
use BankAccount\Domain\Money;
use Exception;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BankAccountTest extends TestCase
{
    #[Test]
    #[DataProvider('validData')]
    public function インスタンス化できる(string $number, int $amount): void
    {
        $accountNumber = new AccountNumber($number);
        $balance = new Balance($amount);
        $bankAccount = new BankAccount($accountNumber, $balance);

        $this->assertSame($accountNumber, $bankAccount->accountNumber);
        $this->assertSame($balance, $bankAccount->balance);
    }

    public static function validData(): array
    {
        return [
            ['00000000', 0],
            ['12345678', 1],
            ['01234567', 10],
            ['99999999', 10000],
        ];
    }

    #[Test]
    #[DataProvider('addData')]
    public function 加算テスト(string $number, int $amount, int $addition): void
    {
        $accountNumber = new AccountNumber($number);
        $balance = new Balance($amount);
        $bankAccount = new BankAccount($accountNumber, $balance);

        $additionMoney = new Money($addition);

        $bankAccount->deposit($additionMoney);

        $this->assertSame($balance->value + $additionMoney->value, $bankAccount->balance->value);
    }

    public static function addData(): array
    {
        return [
            ['00000000', 0, 100],
            ['12345678', 1, 99],
            ['01234567', 10, 990],
        ];
    }

    #[Test]
    #[DataProvider('subtractData')]
    public function 減算テスト(string $number, int $amount, int $subtraction): void
    {
        $accountNumber = new AccountNumber($number);
        $balance = new Balance($amount);
        $bankAccount = new BankAccount($accountNumber, $balance);

        $subtractionMoney = new Money($subtraction);

        $bankAccount->withdraw($subtractionMoney);

        $this->assertSame($balance->value - $subtractionMoney->value, $bankAccount->balance->value);
    }

    public static function subtractData(): array
    {
        return [
            ['00000000', 100, 0],
            ['12345678', 99, 1],
        ];
    }

    #[Test]
    #[DataProvider('invalidSubtractData')]
    public function 減算できない場合は例外が投げられる(string $number, int $amount, int $subtraction): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('残高不足です');

        $accountNumber = new AccountNumber($number);
        $balance = new Balance($amount);
        $bankAccount = new BankAccount($accountNumber, $balance);

        $subtractionMoney = new Money($subtraction);

        $bankAccount->withdraw($subtractionMoney);
    }

    public static function invalidSubtractData(): array
    {
        return [
            ['00000000', 0, 1],
            ['01234567', 1, 2],
            ['12345678', 999, 1000],
        ];
    }
}
