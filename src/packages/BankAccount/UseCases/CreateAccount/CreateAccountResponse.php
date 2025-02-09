<?php

declare(strict_types=1);

namespace BankAccount\UseCases\CreateAccount;

/**
 * 口座作成の結果を表すクラス
 */
class CreateAccountResponse
{
    public function __construct(
        public readonly string $accountNumber,
        public readonly int $balance,
    ) {
    }
}
