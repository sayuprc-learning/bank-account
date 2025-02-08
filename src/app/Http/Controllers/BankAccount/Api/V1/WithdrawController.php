<?php

declare(strict_types=1);

namespace App\Http\Controllers\BankAccount\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Dto\BankAccount\WithdrawDto;
use BankAccount\UseCases\Withdraw\WithdrawRequest;
use BankAccount\UseCases\Withdraw\WithdrawUseCaseInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    public function __construct(
        private readonly WithdrawUseCaseInterface $interactor,
        private readonly WithdrawDto $presenter,
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

        $outputData = $this->interactor->handle(new WithdrawRequest($accountNumber, $amount));

        return response()->json($this->presenter->present($outputData));
    }
}
