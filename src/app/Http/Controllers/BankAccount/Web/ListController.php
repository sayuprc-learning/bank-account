<?php

declare(strict_types=1);

namespace App\Http\Controllers\BankAccount\Web;

use App\Http\Controllers\Controller;
use App\Http\Presenters\BankAccount\ListPresenter;
use BankAccount\UseCases\List\ListUseCaseInterface;
use Illuminate\Contracts\View\View;

class ListController extends Controller
{
    public function __construct(
        private readonly ListUseCaseInterface $interactor,
        private readonly ListPresenter $presenter,
    ) {
    }

    public function handle(): View
    {
        $outputData = $this->interactor->handle();

        return view('bank_accounts.list', ['bankAccounts' => $this->presenter->present($outputData)]);
    }
}
