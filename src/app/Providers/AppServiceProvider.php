<?php

declare(strict_types=1);

namespace App\Providers;

use BankAccount\Applications\List\ListInteractor;
use BankAccount\Applications\Transfer\TransferInteractor;
use BankAccount\Domain\BankAccountRepositoryInterface;
use BankAccount\Infrastructure\FileBankAccountRepository;
use BankAccount\UseCases\List\ListUseCaseInterface;
use BankAccount\UseCases\Transfer\TransferUseCaseInterface;
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

        $this->app->bind(BankAccountRepositoryInterface::class, FileBankAccountRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
