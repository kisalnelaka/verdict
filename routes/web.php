<?php

use App\Http\Controllers\DecisionController;
use App\Http\Controllers\ActionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DecisionController::class, 'index'])->name('timeline');
Route::get('/decisions/create', [ActionController::class, 'createDecision'])->name('decisions.create');
Route::post('/decisions', [ActionController::class, 'storeDecision'])->name('decisions.store');
Route::get('/decisions/{decision}', [DecisionController::class, 'show'])->name('decisions.show');
Route::post('/decisions/{decision}/energy', [ActionController::class, 'recordEnergy'])->name('decisions.energy');
Route::post('/decisions/{decision}/outcomes', [ActionController::class, 'storeOutcome'])->name('decisions.outcomes');

Route::post('/decisions/{decision}/resolve', [ActionController::class, 'resolveDecision'])->name('decisions.resolve');

Route::get('/ledger', [DecisionController::class, 'verify'])->name('ledger');
Route::get('/actors/{user}', [DecisionController::class, 'actorShow'])->name('actors.show');

Route::get('/system/cockpit', [ActionController::class, 'systemCockpit'])->name('system.actions');
Route::post('/system/sync-git', [ActionController::class, 'syncGit'])->name('system.sync');
Route::post('/system/enforce', [ActionController::class, 'runEnforce'])->name('system.enforce');
Route::post('/system/verify', [ActionController::class, 'runVerify'])->name('system.verify');