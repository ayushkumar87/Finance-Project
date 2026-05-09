<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/', [FinanceController::class, 'dashboard'])->name('dashboard');
    Route::get('/transactions', [FinanceController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create', [FinanceController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [FinanceController::class, 'store'])->name('transactions.store');
    Route::delete('/transactions/{transaction}', [FinanceController::class, 'destroy'])->name('transactions.destroy');
    Route::get('/transactions/export', [FinanceController::class, 'exportCsv'])->name('transactions.export');
});

Route::get('/literacy', [FinanceController::class, 'literacy'])->name('literacy');
Route::get('/news', [FinanceController::class, 'news'])->name('news');
