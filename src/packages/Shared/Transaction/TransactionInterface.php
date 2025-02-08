<?php

declare(strict_types=1);

namespace Shared\Transaction;

use Closure;

/**
 * トランザクション管理の処理を抽象化したもの
 */
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
