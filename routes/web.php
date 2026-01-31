<?php

use App\Http\Controllers\DecisionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DecisionController::class, 'index'])->name('timeline');
Route::get('/decisions/{decision}', [DecisionController::class, 'show'])->name('decisions.show');
Route::get('/ledger', [DecisionController::class, 'verify'])->name('ledger');