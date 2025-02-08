<?php

declare(strict_types=1);

namespace App\Http\Controllers\BankAccount\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Dto\BankAccount\DepositDto;
use BankAccount\UseCases\Deposit\DepositRequest;
use BankAccount\UseCases\Deposit\DepositUseCaseInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function __construct(
        private readonly DepositUseCaseInterface $interactor,
        private readonly DepositDto $presenter,
    ) {
    }

    public function handle(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'account_number' => ['required', 'regex:/\A\d{8}\z/'],
            'amount' => ['required', 'integer', 'min:1'],
        ]);

        $accountNumber = $validated['account_number'];
        $amount = (int)$validated['amount'];

        $outputData = $this->interactor->handle(new DepositRequest($accountNumber, $amount));

        return response()->json($this->presenter->present($outputData));
    }
}
