<?php

declare(strict_types=1);

use App\Http\Controllers\BankAccount\Api\V1\CreateAccountController;
use App\Http\Controllers\BankAccount\Api\V1\DepositController;
use App\Http\Controllers\BankAccount\Api\V1\ListController;
use App\Http\Controllers\BankAccount\Api\V1\TransferController;
use App\Http\Controllers\BankAccount\Api\V1\WithdrawController;
use Illuminate\Support\Facades\Route;
use Shared\Route\Api\V1\RouteMap;

Route::prefix('v1')->group(function () {
    // 口座作成
    Route::post('create', [CreateAccountController::class, 'handle'])->name(RouteMap::Create);

    // 口座一覧
    Route::get('list', [ListController::class, 'handle'])->name(RouteMap::List);

    // 口座振込
    Route::post('transfer', [TransferController::class, 'handle'])->name(RouteMap::Transfer);

    // 口座入金
    Route::post('deposit', [DepositController::class, 'handle'])->name(RouteMap::Deposit);

    // 口座引き落とし
    Route::post('withdraw', [WithdrawController::class, 'handle'])->name(RouteMap::Withdraw);
});
