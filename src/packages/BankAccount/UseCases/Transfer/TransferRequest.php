<?php

declare(strict_types=1);

namespace BankAccount\UseCases\Transfer;

class TransferRequest
{
    public function __construct(
        public readonly string $fromAccountNumber,
        public readonly string $toAccountNumber,
        public readonly int $amount,
    ) {
    }
}
