<?php

declare(strict_types=1);

namespace BankAccount\UseCases\Deposit;

interface DepositUseCaseInterface
{
    public function handle(DepositRequest $request): DepositResponse;
}
