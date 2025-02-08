<?php

declare(strict_types=1);

namespace BankAccount\UseCases\Deposit;

/**
 * 口座入金のユースケースを抽象化したもの
 */
interface DepositUseCaseInterface
{
    public function handle(DepositRequest $request): DepositResponse;
}
