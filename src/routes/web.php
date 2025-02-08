<?php

declare(strict_types=1);

use App\Http\Controllers\BankAccount\Web\ListController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/list', [ListController::class, 'handle']);
