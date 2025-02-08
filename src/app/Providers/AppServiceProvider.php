<?php

declare(strict_types=1);

namespace App\Providers;

use BankAccount\Applications\CreateAccount\CreateAccountInteractor;
use BankAccount\Applications\Deposit\DepositInteractor;
use BankAccount\Applications\List\ListInteractor;
use BankAccount\Applications\Transfer\TransferInteractor;
use BankAccount\Applications\Withdraw\WithdrawInteractor;
use BankAccount\Domain\BankAccountRepositoryInterface;
use BankAccount\Infrastructure\FileBankAccountRepository;
use BankAccount\UseCases\CreateAccount\CreateAccountUseCaseInterface;
use BankAccount\UseCases\Deposit\DepositUseCaseInterface;
use BankAccount\UseCases\List\ListUseCaseInterface;
use BankAccount\UseCases\Transfer\TransferUseCaseInterface;
use BankAccount\UseCases\Withdraw\WithdrawUseCaseInterface;
use Illuminate\Support\ServiceProvider;
use Shared\DebugTransaction\NopTransaction;
use Shared\Transaction\TransactionInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TransactionInterface::class, NopTransaction::class);

        $this->app->bind(ListUseCaseInterface::class, ListInteractor::class);
        $this->app->bind(TransferUseCaseInterface::class, TransferInteractor::class);
        $this->app->bind(CreateAccountUseCaseInterface::class, CreateAccountInteractor::class);
        $this->app->bind(DepositUseCaseInterface::class, DepositInteractor::class);
        $this->app->bind(WithdrawUseCaseInterface::class, WithdrawInteractor::class);

        $this->app->bind(BankAccountRepositoryInterface::class, FileBankAccountRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
