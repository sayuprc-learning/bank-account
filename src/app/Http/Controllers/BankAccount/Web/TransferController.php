<?php

declare(strict_types=1);

namespace App\Http\Controllers\BankAccount\Web;

use App\Http\Controllers\Controller;
use BankAccount\UseCases\Transfer\TransferRequest;
use BankAccount\UseCases\Transfer\TransferUseCaseInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Shared\Route\Web\RouteMap;

class TransferController extends Controller
{
    public function view(): View
    {
        return view('bank_accounts.transfer');
    }

    public function handle(Request $request, TransferUseCaseInterface $interactor): RedirectResponse
    {
        $validated = $request->validate([
            'from_account_number' => ['required', 'regex:/\A\d{8}\z/'],
            'to_account_number' => ['required', 'regex:/\A\d{8}\z/'],
            'amount' => ['required', 'integer', 'min:1'],
        ]);

        $fromAccountNumber = $validated['from_account_number'];
        $toAccountNumber = $validated['to_account_number'];
        $amount = (int)$validated['amount'];

        $interactor->handle(new TransferRequest($fromAccountNumber, $toAccountNumber, $amount));

        return redirect()->route(RouteMap::List);
    }
}
