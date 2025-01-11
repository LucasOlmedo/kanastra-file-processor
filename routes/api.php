<?php

use App\Http\Controllers\DebtController;
use Illuminate\Support\Facades\Route;

Route::post('upload-debts', [DebtController::class, 'uploadDebtFile']);
