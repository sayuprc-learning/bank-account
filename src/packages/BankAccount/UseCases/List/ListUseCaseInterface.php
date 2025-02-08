<?php

declare(strict_types=1);

namespace BankAccount\UseCases\List;

interface ListUseCaseInterface
{
    public function handle(): ListResponse;
}
