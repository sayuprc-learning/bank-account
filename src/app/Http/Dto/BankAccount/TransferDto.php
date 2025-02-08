<?php

declare(strict_types=1);

namespace App\Http\Dto\BankAccount;

use BankAccount\UseCases\Transfer\TransferResponse;

class TransferDto
{
    /**
     * @return array{from_account_number: string, to_account_number: string, amount: positive-int, balance: positive-int}
     */
    public function present(TransferResponse $outputData): array
    {
        return [
            'from_account_number' => $outputData->fromAccountNumber,
            'to_account_number' => $outputData->toAccountNumber,
            'amount' => $outputData->amount,
            'balance' => $outputData->balance,
        ];
    }
}
