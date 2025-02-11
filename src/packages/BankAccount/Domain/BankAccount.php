<?php

declare(strict_types=1);

namespace BankAccount\Domain;

use Exception;

/**
 * 口座を合わらすクラス
 *
 * AccountNumber を ID としている
 */
class BankAccount
{
    public function __construct(
        public readonly AccountNumber $accountNumber,
        private(set) Balance $balance,
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
