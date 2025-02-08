<?php

declare(strict_types=1);

namespace BankAccount\UseCases\Withdraw;

interface WithdrawUseCaseInterface
{
    public function handle(WithdrawRequest $request): WithdrawResponse;
}
