<?php

declare(strict_types=1);

namespace App\Http\Controllers\BankAccount\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Dto\BankAccount\TransferDto;
use BankAccount\UseCases\Transfer\TransferRequest;
use BankAccount\UseCases\Transfer\TransferUseCaseInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function __construct(
        private readonly TransferUseCaseInterface $interactor,
        private readonly TransferDto $presenter,
    ) {
    }

    public function handle(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'from_account_number' => ['required', 'regex:/\A\d{8}\z/'],
            'to_account_number' => ['required', 'regex:/\A\d{8}\z/'],
            'amount' => ['required', 'integer', 'min:1'],
        ]);

        $fromAccountNumber = $validated['from_account_number'];
        $toAccountNumber = $validated['to_account_number'];
        $amount = (int)$validated['amount'];

        $outputData = $this->interactor->handle(new TransferRequest($fromAccountNumber, $toAccountNumber, $amount));

        return response()->json($this->presenter->present($outputData));
    }
}
