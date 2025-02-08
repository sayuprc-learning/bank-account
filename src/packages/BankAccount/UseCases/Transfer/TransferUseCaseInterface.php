<?php

declare(strict_types=1);

namespace BankAccount\UseCases\Transfer;

interface TransferUseCaseInterface
{
    public function handle(TransferRequest $request): TransferResponse;
}
