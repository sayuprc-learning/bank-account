<?php

declare(strict_types=1);

namespace BankAccount\UseCases\CreateAccount;

/**
 * 口座作成のユースケースを抽象化したもの
 */
interface CreateAccountUseCaseInterface
{
    public function handle(CreateAccountRequest $request): CreateAccountResponse;
}
