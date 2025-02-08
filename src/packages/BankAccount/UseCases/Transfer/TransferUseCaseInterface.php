<?php

declare(strict_types=1);

namespace BankAccount\UseCases\Transfer;

/**
 * 口座振込のユースケースを抽象化したもの
 */
interface TransferUseCaseInterface
{
    public function handle(TransferRequest $request): TransferResponse;
}
