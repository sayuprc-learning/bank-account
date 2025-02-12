<?php

declare(strict_types=1);

namespace BankAccount\Applications\Deposit;

use BankAccount\Domain\AccountNumber;
use BankAccount\Domain\BankAccountRepositoryInterface;
use BankAccount\Domain\BankAccountService;
use BankAccount\Domain\Money;
use BankAccount\UseCases\Deposit\DepositRequest;
use BankAccount\UseCases\Deposit\DepositResponse;
use BankAccount\UseCases\Deposit\DepositUseCaseInterface;
use Exception;
use Shared\Transaction\TransactionInterface;

/**
 * 口座入金のユースケースを実装したクラス
 */
class DepositInteractor implements DepositUseCaseInterface
{
    public function __construct(
        private readonly TransactionInterface $scope,
        private readonly BankAccountRepositoryInterface $bankAccountRepository,
        private readonly BankAccountService $bankAccountService,
    ) {
    }

    public function handle(DepositRequest $request): DepositResponse
    {
        $result = $this->scope->transaction(function () use ($request) {
            if ($request->amount < 1) {
                throw new Exception('入金額は 1 以上である必要があります');
            }

            $bankAccount = $this->bankAccountService->getBankAccount(new AccountNumber($request->accountNumber));

            $amount = new Money($request->amount);

            $bankAccount->deposit($amount);

            $this->bankAccountRepository->save($bankAccount);

            return $bankAccount->balance->value;
        });

        return new DepositResponse(
            $request->accountNumber,
            $result,
        );
    }
}
