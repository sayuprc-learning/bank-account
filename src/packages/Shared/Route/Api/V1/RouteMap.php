<?php

declare(strict_types=1);

namespace Shared\Route\Api\V1;

enum RouteMap: string
{
    // 口座作成
    case Create = 'v1.create';

    // 口座一覧
    case List = 'v1.list';

    // 口座振込
    case Transfer = 'v1.transfer';

    // 口座入金
    case Deposit = 'v1.deposit';

    // 口座引き落とし
    case Withdraw = 'v1.withdraw';
}
