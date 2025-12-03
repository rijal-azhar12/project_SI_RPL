<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'Kasir'])->group(function () {
    Route::get('/cashier', function () {
        return view('cashier');
    })->name('cashier');
});

Route::middleware(['auth', 'Owner'])->group(function () {
    Route::resource('expense', ExpenseController::class);
    Route::resource('menu', MenuController::class);
    Route::resource('income', IncomeController::class);
    Route::resource('account', AccountController::class);
});