<?php

declare(strict_types=1);

namespace App\Http\Dto\BankAccount;

use BankAccount\UseCases\Withdraw\WithdrawResponse;

class WithdrawDto
{
    /**
     * @return array{account_number: string, amount: positive-int, balance: positive-int}
     */
    public function present(WithdrawResponse $outputData): array
    {
        return [
            'account_number' => $outputData->accountNumber,
            'amount' => $outputData->amount,
            'balance' => $outputData->balance,
        ];
    }
}
