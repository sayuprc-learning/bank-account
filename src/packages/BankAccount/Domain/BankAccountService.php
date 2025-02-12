<?php

declare(strict_types=1);

namespace BankAccount\Domain;

use Exception;

/**
 * BankAccount に関するサービス
 */
class BankAccountService
{
    public function __construct(private readonly BankAccountRepositoryInterface $bankAccountRepository)
    {
    }

    /**
     * @throws Exception
     */
    public function getBankAccount(AccountNumber $accountNumber): BankAccount
    {
        $found = $this->bankAccountRepository->find($accountNumber);

        if (is_null($found)) {
            throw new Exception('口座が存在しません: ' . $accountNumber->value);
        }

        return $found;
    }
}
