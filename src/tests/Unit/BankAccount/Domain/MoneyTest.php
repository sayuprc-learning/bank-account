<?php

declare(strict_types=1);

namespace Tests\Unit\BankAccount\Domain;

use BankAccount\Domain\Money;
use Exception;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MoneyTest extends TestCase
{
    #[Test]
    #[DataProvider('validData')]
    public function インスタンス化できる(int $value): void
    {
        $money = new Money($value);

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
        $this->expectExceptionMessage('金額は 0 以上でなければいけません');

        new Money($value);
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
        $baseMoney = new Money($base);
        $additionMoney = new Money($addition);

        $result = $baseMoney->add($additionMoney);

        $this->assertSame($base + $addition, $result->value);
        // 加算後のインスタンスが別物であることをテスト
        $this->assertNotSame($baseMoney, $result);
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
    #[DataProvider('subtractData')]
    public function 減算テスト(int $base, int $subtraction): void
    {
        $baseMoney = new Money($base);
        $subtractionMoney = new Money($subtraction);

        $result = $baseMoney->subtract($subtractionMoney);

        $this->assertSame($base - $subtraction, $result->value);
        // 減算後のインスタンスが別物であることをテスト
        $this->assertNotSame($baseMoney, $result);
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
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('残高不足です');

        $baseMoney = new Money($base);
        $subtractionMoney = new Money($subtraction);

        $baseMoney->subtract($subtractionMoney);
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
