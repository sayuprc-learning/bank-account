<?php

declare(strict_types=1);

namespace Shared\Transaction;

use Closure;

interface TransactionInterface
{
    /**
     * @template T
     *
     * @param Closure(): T $callback
     *
     * @return T
     */
    public function transaction(Closure $callback): mixed;
}
