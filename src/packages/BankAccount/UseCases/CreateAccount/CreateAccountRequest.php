<?php

declare(strict_types=1);

namespace BankAccount\UseCases\CreateAccount;

/**
 * 口座作成に必要な要素のクラス
 */
class CreateAccountRequest
{
    public function __construct(public readonly int $amount)
    {
    }
}
