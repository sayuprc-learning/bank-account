<?php

declare(strict_types=1);

namespace BankAccount\UseCases\Withdraw;

/**
 * 口座引き落としの結果を表すクラス
 */
class WithdrawResponse
{
    public function __construct(
        public readonly string $accountNumber,
        public readonly int $amount,
        public readonly int $balance,
    ) {
    }
}
