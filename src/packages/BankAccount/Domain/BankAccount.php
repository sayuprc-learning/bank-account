<?php

declare(strict_types=1);

namespace BankAccount\Domain;

use Exception;

class BankAccount
{
    public function __construct(
        public readonly AccountNumber $accountNumber,
        private(set) Money $balance,
    ) {
    }

    /**
     * @throws Exception
     */
    public function deposit(Money $amount): void
    {
        $this->balance = $this->balance->add($amount);
    }

    /**
     * @throws Exception
     */
    public function withdraw(Money $amount): void
    {
        $this->balance = $this->balance->subtract($amount);
    }
}
