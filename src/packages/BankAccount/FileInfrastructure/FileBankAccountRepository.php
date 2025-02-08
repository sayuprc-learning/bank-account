<?php

declare(strict_types=1);

namespace BankAccount\FileInfrastructure;

use BankAccount\Domain\AccountNumber;
use BankAccount\Domain\BankAccount;
use BankAccount\Domain\BankAccountRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class FileBankAccountRepository implements BankAccountRepositoryInterface
{
    public function find(AccountNumber $accountNumber): ?BankAccount
    {
        if (! Storage::exists($fileName = $this->getFileName($accountNumber))) {
            return null;
        }

        return unserialize(Storage::get($fileName));
    }

    public function save(BankAccount $bankAccount): void
    {
        Storage::put($this->getFileName($bankAccount->accountNumber), serialize($bankAccount));
    }

    private function getFileName(AccountNumber $accountNumber): string
    {
        return sprintf('%s.dat', $accountNumber->value);
    }
}
