<?php

declare(strict_types=1);

namespace BankAccount\UseCases\Withdraw;

/**
 * 口座引き落としに必要な要素のクラス
 */
class WithdrawRequest
{
    public function __construct(
        public readonly string $accountNumber,
        public readonly int $amount,
    ) {
    }
}
