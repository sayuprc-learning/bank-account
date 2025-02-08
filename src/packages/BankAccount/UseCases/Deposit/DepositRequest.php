<?php

declare(strict_types=1);

namespace BankAccount\UseCases\Deposit;

class DepositRequest
{
    public function __construct(
        public readonly string $accountNumber,
        public readonly int $amount,
    ) {
    }
}
