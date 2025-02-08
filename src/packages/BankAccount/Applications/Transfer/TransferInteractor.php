<?php

declare(strict_types=1);

namespace BankAccount\Applications\Transfer;

use BankAccount\Domain\AccountNumber;
use BankAccount\Domain\BankAccountRepositoryInterface;
use BankAccount\Domain\Money;
use BankAccount\UseCases\Transfer\TransferRequest;
use BankAccount\UseCases\Transfer\TransferResponse;
use BankAccount\UseCases\Transfer\TransferUseCaseInterface;
use Exception;
use Shared\Transaction\TransactionInterface;

class TransferInteractor implements TransferUseCaseInterface
{
    public function __construct(
        private readonly TransactionInterface $scope,
        private readonly BankAccountRepositoryInterface $bankAccountRepository,
    ) {
    }

    public function handle(TransferRequest $request): TransferResponse
    {
        $result = $this->scope->transaction(function () use ($request) {
            if ($request->amount < 1) {
                throw new Exception('振込額は 1 以上の必要があります');
            }

            if ($request->fromAccountNumber === $request->toAccountNumber) {
                throw new Exception('振込元口座と振込先口座を同じにすることはできません');
            }

            if (is_null($fromBankAccount = $this->bankAccountRepository->find(new AccountNumber($request->fromAccountNumber)))) {
                throw new Exception('振込元口座が見つかりませんでした');
            }

            if (is_null($toBankAccount = $this->bankAccountRepository->find(new AccountNumber($request->toAccountNumber)))) {
                throw new Exception('振込先口座が見つかりませんでした');
            }

            $amount = new Money($request->amount);

            $fromBankAccount->withdraw($amount);
            $toBankAccount->deposit($amount);

            $this->bankAccountRepository->save($fromBankAccount);
            $this->bankAccountRepository->save($toBankAccount);

            return $fromBankAccount->balance->value;
        });

        return new TransferResponse(
            $request->fromAccountNumber,
            $request->toAccountNumber,
            $request->amount,
            $result,
        );
    }
}
