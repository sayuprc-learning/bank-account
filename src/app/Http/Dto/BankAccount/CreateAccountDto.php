<?php

declare(strict_types=1);

namespace App\Http\Dto\BankAccount;

use BankAccount\UseCases\CreateAccount\CreateAccountResponse;

class CreateAccountDto
{
    /**
     * @return array{account_number: string, balance: positive-int}
     */
    public function present(CreateAccountResponse $outputData): array
    {
        return [
            'account_number' => $outputData->accountNumber,
            'balance' => $outputData->balance,
        ];
    }
}
