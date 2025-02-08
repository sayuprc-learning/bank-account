<?php

declare(strict_types=1);

namespace BankAccount\Infrastructure;

use BankAccount\Domain\AccountNumber;
use BankAccount\Domain\BankAccount;
use BankAccount\Domain\BankAccountRepositoryInterface;
use BankAccount\Domain\Money;
use Illuminate\Support\Facades\DB;

/**
 * Laravel の DB Facade を利用したリポジトリの実装
 */
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

    /**
     * @return array<BankAccount>
     */
    public function all(): array
    {
        return DB::table('bank_accounts')->get()
            ->map(function ($record) {
                return new BankAccount(
                    new AccountNumber($record->account_number),
                    new Money($record->balance)
                );
            })
            ->toArray();
    }
}
