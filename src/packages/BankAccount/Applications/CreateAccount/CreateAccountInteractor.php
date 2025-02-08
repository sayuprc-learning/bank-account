<?php

declare(strict_types=1);

namespace BankAccount\Applications\CreateAccount;

use BankAccount\Domain\AccountNumber;
use BankAccount\Domain\BankAccount;
use BankAccount\Domain\BankAccountRepositoryInterface;
use BankAccount\Domain\Money;
use BankAccount\UseCases\CreateAccount\CreateAccountRequest;
use BankAccount\UseCases\CreateAccount\CreateAccountUseCaseInterface;
use Exception;
use Shared\Transaction\TransactionInterface;

/**
 * 口座作成のユースケースを実装したクラス
 */
class CreateAccountInteractor implements CreateAccountUseCaseInterface
{
    public function __construct(
        private readonly TransactionInterface $scope,
        private readonly BankAccountRepositoryInterface $bankAccountRepository,
    ) {
    }

    public function handle(CreateAccountRequest $request): void
    {
        $this->scope->transaction(function () use ($request) {
            if ($request->amount < 0) {
                throw new Exception('入金額は 0 以上の必要があります');
            }

            if (! is_null($this->bankAccountRepository->find($accountNumber = new AccountNumber($request->accountNumber)))) {
                throw new Exception('指定の口座番号は使えません');
            }

            $bankAccount = new BankAccount($accountNumber, new Money($request->amount));

            $this->bankAccountRepository->save($bankAccount);
        });
    }
}
