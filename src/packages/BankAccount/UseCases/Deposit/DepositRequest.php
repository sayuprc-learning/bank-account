<?php

declare(strict_types=1);

namespace BankAccount\UseCases\Deposit;

/**
 * 口座入金に必要な要素のクラス
 */
class DepositRequest
{
    public function __construct(
        public readonly string $accountNumber,
        public readonly int $amount,
    ) {
    }
}
