<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\RecuController;

Route::get('/', function () {
    return view('auth/login');
});


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('recus', RecuController::class)
        ->only(['index', 'create', 'store', 'show', 'destroy']);

    Route::get('/depenses', [DepenseController::class, 'index'])->name('depenses.index');
});

require __DIR__.'/auth.php';
