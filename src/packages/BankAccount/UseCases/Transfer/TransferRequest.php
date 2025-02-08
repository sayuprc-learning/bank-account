<?php

declare(strict_types=1);

namespace BankAccount\UseCases\Transfer;

/**
 * 口座振込に必要な要素のクラス
 */
class TransferRequest
{
    public function __construct(
        public readonly string $fromAccountNumber,
        public readonly string $toAccountNumber,
        public readonly int $amount,
    ) {
    }
}
