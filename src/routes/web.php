<?php

declare(strict_types=1);

use App\Http\Controllers\BankAccount\Web\CreateAccountController;
use App\Http\Controllers\BankAccount\Web\DepositController;
use App\Http\Controllers\BankAccount\Web\ListController;
use App\Http\Controllers\BankAccount\Web\TransferController;
use App\Http\Controllers\BankAccount\Web\WithdrawController;
use Illuminate\Support\Facades\Route;
use Shared\Route\Web\RouteMap;

Route::get('list', [ListController::class, 'handle'])->name(RouteMap::List);

Route::get('transfer', [TransferController::class, 'view'])->name(RouteMap::TransferView);
Route::post('transfer', [TransferController::class, 'handle'])->name(RouteMap::Transfer);

Route::get('create', [CreateAccountController::class, 'view'])->name(RouteMap::CreateView);
Route::post('create', [CreateAccountController::class, 'handle'])->name(RouteMap::Create);

Route::get('deposit', [DepositController::class, 'view'])->name(RouteMap::DepositView);
Route::post('deposit', [DepositController::class, 'handle'])->name(RouteMap::Deposit);

Route::get('withdraw', [WithdrawController::class, 'view'])->name(RouteMap::WithdrawView);
Route::post('withdraw', [WithdrawController::class, 'handle'])->name(RouteMap::Withdraw);
