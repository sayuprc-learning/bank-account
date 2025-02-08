<?php

declare(strict_types=1);

namespace BankAccount\Applications\Withdraw;

use BankAccount\Domain\AccountNumber;
use BankAccount\Domain\BankAccountRepositoryInterface;
use BankAccount\Domain\Money;
use BankAccount\UseCases\Withdraw\WithdrawRequest;
use BankAccount\UseCases\Withdraw\WithdrawResponse;
use BankAccount\UseCases\Withdraw\WithdrawUseCaseInterface;
use Exception;
use Shared\Transaction\TransactionInterface;

/**
 * 口座引き落としのユースケースを実装したクラス
 */
class WithdrawInteractor implements WithdrawUseCaseInterface
{
    public function __construct(
        private readonly TransactionInterface $scope,
        private readonly BankAccountRepositoryInterface $bankAccountRepository,
    ) {
    }

    public function handle(WithdrawRequest $request): WithdrawResponse
    {
        $result = $this->scope->transaction(function () use ($request) {
            if ($request->amount < 1) {
                throw new Exception('引き落とし額は 1 以上の必要があります');
            }

            if (is_null($bankAccount = $this->bankAccountRepository->find(new AccountNumber($request->accountNumber)))) {
                throw new Exception('引き落とし先口座が見つかりませんでした');
            }

            $amount = new Money($request->amount);

            $bankAccount->withdraw($amount);

            $this->bankAccountRepository->save($bankAccount);

            return $bankAccount->balance->value;
        });

        return new WithdrawResponse(
            $request->accountNumber,
            $request->amount,
            $result,
        );
    }
}
