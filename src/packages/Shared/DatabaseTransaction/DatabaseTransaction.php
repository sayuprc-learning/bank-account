<?php

declare(strict_types=1);

namespace Shared\DatabaseTransaction;

use Closure;
use Illuminate\Support\Facades\DB;
use Shared\Transaction\TransactionInterface;

/**
 * Laravel の DB::transaction() を利用したトランザクション管理クラス
 */
class DatabaseTransaction implements TransactionInterface
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
        return DB::transaction($callback);
    }
}
