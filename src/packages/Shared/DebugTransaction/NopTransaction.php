<?php

declare(strict_types=1);

namespace Shared\DebugTransaction;

use Closure;
use Shared\Transaction\TransactionInterface;

/**
 * 何もしないトランザクション管理クラス
 */
class NopTransaction implements TransactionInterface
{
    /**
     * @template T
     *
     * @param Closure(): T $callback
     *
     * @return T
     */
    public function transaction(Closure $callback): mixed
    {
        return $callback();
    }
}
