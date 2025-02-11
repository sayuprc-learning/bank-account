<?php

declare(strict_types=1);

namespace Tests\Unit\BankAccount\Domain;

use BankAccount\Domain\Balance;
use BankAccount\Domain\Money;
use Exception;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BalanceTest extends TestCase
{
    #[Test]
    #[DataProvider('validData')]
    public function インスタンス化できる(int $value): void
    {
        $money = new Balance($value);

        $this->assertSame($money->value, $value);
    }

    public static function validData(): array
    {
        return [
            [0],
            [1],
            [10],
            [100],
            [1000],
            [10000],
        ];
    }

    #[Test]
    #[DataProvider('invalidData')]
    public function インスタンス化で例外が投げられる(int $value): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('残高は 0 以上でなければいけません');

        new Balance($value);
    }

    public static function invalidData(): array
    {
        return [
            [-1],
            [-10],
            [-100],
            [-1000],
            [-10000],
        ];
    }

    #[Test]
    #[DataProvider('addData')]
    public function 加算テスト(int $base, int $addition): void
    {
        $balance = new Balance($base);
        $money = new Money($addition);

        $result = $balance->add($money);

        $this->assertSame($base + $addition, $result->value);
        // 加算後のインスタンスが別物であることをテスト
        $this->assertNotSame($balance, $result);
    }

    public static function addData(): array
    {
        return [
            [0, 100],
            [1, 99],
            [10, 990],
        ];
    }

    #[Test]
    #[DataProvider('invalidAddData')]
    public function 加算に負の数を与えたら例外(int $base, int $addition): void
    {
        $this->expectexception(Exception::class);
        $this->expectexceptionmessage('金額は 0 以上でなければいけません');

        $balance = new Balance($base);
        $money = new Money($addition);

        $balance->add($money);
    }

    public static function invalidAddData(): array
    {
        return [
            [0, -100],
            [1, -99],
            [10, -990],
        ];
    }

    #[Test]
    #[DataProvider('subtractData')]
    public function 減算テスト(int $base, int $subtraction): void
    {
        $balance = new Balance($base);
        $money = new Money($subtraction);

        $result = $balance->subtract($money);

        $this->assertSame($base - $subtraction, $result->value);
        // 減算後のインスタンスが別物であることをテスト
        $this->assertNotSame($balance, $result);
    }

    public static function subtractData(): array
    {
        return [
            [100, 0],
            [99, 1],
        ];
    }

    #[Test]
    #[DataProvider('invalidSubtractData')]
    public function 減算できない場合は例外が投げられる(int $base, int $subtraction): void
    {
        $this->expectexception(Exception::class);
        $this->expectexceptionmessage('残高不足です');

        $balance = new Balance($base);
        $money = new Money($subtraction);

        $balance->subtract($money);
    }

    public static function invalidSubtractData(): array
    {
        return [
            [0, 1],
            [1, 2],
            [999, 1000],
        ];
    }
}
