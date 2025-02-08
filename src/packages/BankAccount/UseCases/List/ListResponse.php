<?php

declare(strict_types=1);

namespace BankAccount\UseCases\List;

use BankAccount\Domain\BankAccount;

/**
 * 口座一覧の結果を表すクラス
 */
class ListResponse
{
    /**
     * @param array<BankAccount> $bankAccounts
     */
    public function __construct(public readonly array $bankAccounts)
    {
    }
}
