<?php

declare(strict_types=1);

namespace BankAccount\Applications\Transfer;

use BankAccount\Domain\AccountNumber;
use BankAccount\Domain\BankAccountRepositoryInterface;
use BankAccount\Domain\BankAccountService;
use BankAccount\Domain\Money;
use BankAccount\UseCases\Transfer\TransferRequest;
use BankAccount\UseCases\Transfer\TransferResponse;
use BankAccount\UseCases\Transfer\TransferUseCaseInterface;
use Exception;
use Shared\Transaction\TransactionInterface;

/**
 * 口座振込のユースケースを実装したクラス
 */
class TransferInteractor implements TransferUseCaseInterface
{
    public function __construct(
        private readonly TransactionInterface $scope,
        private readonly BankAccountRepositoryInterface $bankAccountRepository,
        private readonly BankAccountService $bankAccountService,
    ) {
    }

    public function handle(TransferRequest $request): TransferResponse
    {
        $result = $this->scope->transaction(function () use ($request) {
            if ($request->amount < 1) {
                throw new Exception('振込額は 1 以上である必要があります');
            }

            if ($request->fromAccountNumber === $request->toAccountNumber) {
                throw new Exception('振込元口座と振込先口座を同じにすることはできません');
            }

            $fromBankAccount = $this->bankAccountService->getBankAccount(new AccountNumber($request->fromAccountNumber));
            $toBankAccount = $this->bankAccountService->getBankAccount(new AccountNumber($request->toAccountNumber));

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
