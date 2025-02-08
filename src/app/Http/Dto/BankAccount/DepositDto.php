<?php

declare(strict_types=1);

namespace App\Http\Dto\BankAccount;

use BankAccount\UseCases\Deposit\DepositResponse;

class DepositDto
{
    /**
     * @return array{account_number: string, balance: positive-int}
     */
    public function present(DepositResponse $outputData): array
    {
        return [
            'account_number' => $outputData->accountNumber,
            'balance' => $outputData->balance,
        ];
    }
}
