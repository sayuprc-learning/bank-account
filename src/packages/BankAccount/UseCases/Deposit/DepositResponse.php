<?php

declare(strict_types=1);

namespace BankAccount\UseCases\Deposit;

class DepositResponse
{
    public function __construct(
        public readonly string $accountNumber,
        public readonly int $balance,
    ) {
    }
}
