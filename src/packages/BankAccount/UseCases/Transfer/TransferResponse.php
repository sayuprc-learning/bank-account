<?php

declare(strict_types=1);

namespace BankAccount\UseCases\Transfer;

/**
 * 口座振込の結果を表すクラス
 */
class TransferResponse
{
    public function __construct(
        public readonly string $fromAccountNumber,
        public readonly string $toAccountNumber,
        public readonly int $amount,
        public readonly int $balance,
    ) {
    }
}
