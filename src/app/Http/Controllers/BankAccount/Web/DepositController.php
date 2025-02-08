<?php

declare(strict_types=1);

namespace App\Http\Controllers\BankAccount\Web;

use App\Http\Controllers\Controller;
use BankAccount\UseCases\Deposit\DepositRequest;
use BankAccount\UseCases\Deposit\DepositUseCaseInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Shared\Route\Web\RouteMap;

class DepositController extends Controller
{
    public function view(): View
    {
        return view('bank_accounts.deposit');
    }

    public function handle(Request $request, DepositUseCaseInterface $interactor): RedirectResponse
    {
        $validated = $request->validate([
            'account_number' => ['required', 'regex:/\A\d{8}\z/'],
            'amount' => ['required', 'integer', 'min:1'],
        ]);

        $accountNumber = $validated['account_number'];
        $amount = (int)$validated['amount'];

        $interactor->handle(new DepositRequest($accountNumber, $amount));

        return redirect()->route(RouteMap::List);
    }
}
