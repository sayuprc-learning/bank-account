<?php

declare(strict_types=1);

namespace BankAccount\Domain;

/**
 * 口座のリポジトリを抽象化したもの
 */
interface BankAccountRepositoryInterface
{
    public function find(AccountNumber $accountNumber): ?BankAccount;

    public function save(BankAccount $bankAccount): void;

    /**
     * @return array<BankAccount>
     */
    public function all(): array;
}
