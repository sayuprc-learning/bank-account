<?php

declare(strict_types=1);

namespace BankAccount\Applications\CreateAccount;

use BankAccount\Domain\AccountNumber;
use BankAccount\Domain\Balance;
use BankAccount\Domain\BankAccount;
use BankAccount\Domain\BankAccountRepositoryInterface;
use BankAccount\UseCases\CreateAccount\CreateAccountRequest;
use BankAccount\UseCases\CreateAccount\CreateAccountResponse;
use BankAccount\UseCases\CreateAccount\CreateAccountUseCaseInterface;
use Exception;
use Shared\Random\RandomGeneratorInterface;
use Shared\Transaction\TransactionInterface;

/**
 * 口座作成のユースケースを実装したクラス
 */
class CreateAccountInteractor implements CreateAccountUseCaseInterface
{
    public function __construct(
        private readonly TransactionInterface $scope,
        private readonly BankAccountRepositoryInterface $bankAccountRepository,
        private readonly RandomGeneratorInterface $generator,
    ) {
    }

    public function handle(CreateAccountRequest $request): CreateAccountResponse
    {
        $result = $this->scope->transaction(function () use ($request) {
            if ($request->amount < 0) {
                throw new Exception('入金額は 0 以上である必要があります');
            }

            $accountNumber = new AccountNumber($this->generator->generate(8));

            if (! is_null($this->bankAccountRepository->find($accountNumber))) {
                throw new Exception('指定の口座番号は使えません');
            }

            $bankAccount = new BankAccount($accountNumber, new Balance($request->amount));

            $this->bankAccountRepository->save($bankAccount);

            return $bankAccount;
        });

        return new CreateAccountResponse(
            $result->accountNumber->value,
            $result->balance->value,
        );
    }
}
