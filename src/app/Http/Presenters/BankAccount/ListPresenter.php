<?php

declare(strict_types=1);

namespace App\Http\Presenters\BankAccount;

use BankAccount\UseCases\List\ListResponse;

class ListPresenter
{
    /**
     * @return array<array{account_number: string, balance: positive-int}>
     */
    public function present(ListResponse $outputData): array
    {
        return array_map(
            fn ($bankAccount) => [
                'account_number' => $bankAccount->accountNumber->value,
                'balance' => number_format($bankAccount->balance->value),
            ],
            $outputData->bankAccounts
        );
    }
}
