<?php

use App\Http\Controllers\AnswerCheckController;
use App\Http\Controllers\DiveAnswerController;
use App\Http\Controllers\DiveController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DiveController::class, 'index'])->name('home');
Route::post('/dives', [DiveController::class, 'store'])->name('dives.store');
Route::get('/dives/{dive}', [DiveController::class, 'show'])->name('dives.show');
Route::post('/dives/{dive}/answers', [DiveAnswerController::class, 'store'])->name('dives.answers.store');
Route::post('/dives/{dive}/answer-checks', [AnswerCheckController::class, 'store'])
    ->middleware('throttle:60,1')
    ->name('dives.answer-checks.store');
