<?php

declare(strict_types=1);

namespace BankAccount\UseCases\List;

use BankAccount\Domain\BankAccount;

class ListResponse
{
    /**
     * @param array<BankAccount> $bankAccounts
     */
    public function __construct(array $bankAccounts)
    {
    }
}
