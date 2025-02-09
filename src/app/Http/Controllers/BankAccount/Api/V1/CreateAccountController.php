<?php

declare(strict_types=1);

namespace App\Http\Controllers\BankAccount\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Dto\BankAccount\CreateAccountDto;
use BankAccount\UseCases\CreateAccount\CreateAccountRequest;
use BankAccount\UseCases\CreateAccount\CreateAccountUseCaseInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateAccountController extends Controller
{
    public function __construct(
        private readonly CreateAccountUseCaseInterface $interactor,
        private readonly CreateAccountDto $presenter,
    ) {
    }

    public function handle(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'amount' => ['required', 'integer', 'min:0'],
        ]);

        $amount = (int)$validated['amount'];

        $outputData = $this->interactor->handle(new CreateAccountRequest($amount));

        return response()->json($this->presenter->present($outputData));
    }
}
