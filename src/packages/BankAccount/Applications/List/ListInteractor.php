<?php

declare(strict_types=1);

namespace BankAccount\Applications\List;

use BankAccount\Domain\BankAccountRepositoryInterface;
use BankAccount\UseCases\List\ListResponse;
use BankAccount\UseCases\List\ListUseCaseInterface;

/**
 * 口座一覧のユースケースを実装したクラス
 */
class ListInteractor implements ListUseCaseInterface
{
    public function __construct(
        private readonly BankAccountRepositoryInterface $bankAccountRepository,
    ) {
    }

    public function handle(): ListResponse
    {
        return new ListResponse($this->bankAccountRepository->all());
    }
}
