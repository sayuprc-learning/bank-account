<?php

declare(strict_types=1);

use App\Http\Controllers\BankAccount\Api\v1\ListController;
use App\Http\Controllers\BankAccount\Api\v1\TransferController;
use Illuminate\Support\Facades\Route;

Route::get('/v1/list', [ListController::class, 'handle']);
Route::post('/v1/transfer', [TransferController::class, 'handle']);
