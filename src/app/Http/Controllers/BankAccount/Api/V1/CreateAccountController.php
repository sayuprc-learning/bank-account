<?php

declare(strict_types=1);

namespace App\Http\Controllers\BankAccount\Api\V1;

use App\Http\Controllers\Controller;
use BankAccount\UseCases\CreateAccount\CreateAccountRequest;
use BankAccount\UseCases\CreateAccount\CreateAccountUseCaseInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateAccountController extends Controller
{
    public function __construct(private readonly CreateAccountUseCaseInterface $interactor)
    {
    }

    public function handle(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'account_number' => ['required', 'regex:/\A\d{8}\z/'],
            'amount' => ['required', 'integer', 'min:0'],
        ]);

        $accountNumber = $validated['account_number'];
        $amount = (int)$validated['amount'];

        $this->interactor->handle(new CreateAccountRequest($accountNumber, $amount));

        return response()->json();
    }
}
