<?php

declare(strict_types=1);

namespace BankAccount\UseCases\CreateAccount;

interface CreateAccountUseCaseInterface
{
    public function handle(CreateAccountRequest $request): void;
}
