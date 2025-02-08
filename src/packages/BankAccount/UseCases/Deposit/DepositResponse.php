<?php

declare(strict_types=1);

namespace BankAccount\UseCases\Deposit;

/**
 * 口座入金の結果を表すクラス
 */
class DepositResponse
{
    public function __construct(
        public readonly string $accountNumber,
        public readonly int $balance,
    ) {
    }
}
