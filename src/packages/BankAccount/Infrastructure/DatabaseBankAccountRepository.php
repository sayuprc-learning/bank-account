<?php

declare(strict_types=1);

namespace BankAccount\Infrastructure;

use BankAccount\Domain\AccountNumber;
use BankAccount\Domain\BankAccount;
use BankAccount\Domain\BankAccountRepositoryInterface;
use BankAccount\Domain\Money;
use Illuminate\Support\Facades\DB;

class DatabaseBankAccountRepository implements BankAccountRepositoryInterface
{
    public function find(AccountNumber $accountNumber): ?BankAccount
    {
        $found = DB::table('bank_accounts')
            ->where('account_number', $accountNumber->value)
            ->first();

        if (is_null($found)) {
            return null;
        }

        return new BankAccount($accountNumber, new Money($found->balance));
    }

    public function save(BankAccount $bankAccount): void
    {
        DB::table('bank_accounts')
            ->updateOrInsert(
                ['account_number' => $bankAccount->accountNumber->value],
                ['balance' => $bankAccount->balance->value],
            );
    }
}
