<?php

declare(strict_types=1);

namespace BankAccount\UseCases\CreateAccount;

class CreateAccountRequest
{
    public function __construct(
        public readonly string $accountNumber,
        public readonly int $amount,
    ) {
    }
}
