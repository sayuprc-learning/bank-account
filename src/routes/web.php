<?php

declare(strict_types=1);

use App\Http\Controllers\BankAccount\Web\ListController;
use App\Http\Controllers\BankAccount\Web\TransferController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/list', [ListController::class, 'handle']);

Route::get('/transfer', [TransferController::class, 'view']);
Route::post('/transfer', [TransferController::class, 'handle']);
