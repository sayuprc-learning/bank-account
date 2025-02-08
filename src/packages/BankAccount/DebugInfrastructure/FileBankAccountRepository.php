<?php

declare(strict_types=1);

namespace BankAccount\DebugInfrastructure;

use BankAccount\Domain\AccountNumber;
use BankAccount\Domain\BankAccount;
use BankAccount\Domain\BankAccountRepositoryInterface;
use Illuminate\Support\Facades\Storage;

/**
 * ファイルを利用したリポジトリの実装
 */
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

    public function all(): array
    {
        return array_map(
            fn ($fileName) => unserialize(Storage::get($fileName)),
            array_filter(Storage::files(), fn ($file) => preg_match('/\A\d{8}\.dat\z/', $file))
        );
    }

    private function getFileName(AccountNumber $accountNumber): string
    {
        return sprintf('%s.dat', $accountNumber->value);
    }
}
