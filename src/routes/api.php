<?php

declare(strict_types=1);

use App\Http\Controllers\BankAccount\Api\V1\CreateAccountController;
use App\Http\Controllers\BankAccount\Api\V1\DepositController;
use App\Http\Controllers\BankAccount\Api\V1\ListController;
use App\Http\Controllers\BankAccount\Api\V1\TransferController;
use App\Http\Controllers\BankAccount\Api\V1\WithdrawController;
use Illuminate\Support\Facades\Route;

Route::get('/v1/list', [ListController::class, 'handle']);
Route::post('/v1/transfer', [TransferController::class, 'handle']);
Route::post('/v1/deposit', [DepositController::class, 'handle']);
Route::post('/v1/withdraw', [WithdrawController::class, 'handle']);
Route::post('/v1/create', [CreateAccountController::class, 'handle']);
