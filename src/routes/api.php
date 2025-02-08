<?php

declare(strict_types=1);

use App\Http\Controllers\BankAccount\Api\v1\TransferController;
use Illuminate\Support\Facades\Route;

Route::post('/v1/transfer', [TransferController::class, 'handle']);
