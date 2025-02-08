<?php

declare(strict_types=1);

namespace Shared\Route\Web;

enum RouteMap: string
{
    // 口座作成画面
    case CreateView = 'create.view';

    // 口座作成
    case Create = 'create';

    // 口座一覧
    case List = 'list';

    // 口座振込画面
    case TransferView = 'transfer.view';

    // 口座振込
    case Transfer = 'transfer';

    // 口座入金画面
    case DepositView = 'deposit.view';

    // 口座入金
    case Deposit = 'deposit';

    // 口座引き落とし画面
    case WithdrawView = 'withdraw.view';

    // 口座引き落とし
    case Withdraw = 'withdraw';
}
