<?php

declare(strict_types=1);

namespace BankAccount\UseCases\Withdraw;

/**
 * 口座引き落としのユースケースを抽象化したもの
 */
interface WithdrawUseCaseInterface
{
    public function handle(WithdrawRequest $request): WithdrawResponse;
}
