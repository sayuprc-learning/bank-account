<?php

declare(strict_types=1);

namespace App\Http\Controllers\BankAccount\Web;

use App\Http\Controllers\Controller;
use BankAccount\UseCases\CreateAccount\CreateAccountRequest;
use BankAccount\UseCases\CreateAccount\CreateAccountUseCaseInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Shared\Route\Web\RouteMap;

class CreateAccountController extends Controller
{
    public function view(): View
    {
        return view('bank_accounts.create');
    }

    public function handle(Request $request, CreateAccountUseCaseInterface $interactor): RedirectResponse
    {
        $validated = $request->validate([
            'account_number' => ['required', 'regex:/\A\d{8}\z/'],
            'amount' => ['required', 'integer', 'min:0'],
        ]);

        $accountNumber = $validated['account_number'];
        $amount = (int)$validated['amount'];

        $interactor->handle(new CreateAccountRequest($accountNumber, $amount));

        return redirect()->route(RouteMap::List);
    }
}
