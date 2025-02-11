<?php

declare(strict_types=1);

namespace Tests\Unit\BankAccount\Domain;

use BankAccount\Domain\Money;
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
            [-1],
            [-10],
            [-100],
            [-1000],
            [-10000],
        ];
    }
}
