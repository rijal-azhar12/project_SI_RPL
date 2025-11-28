<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IncomeController;

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

Route::middleware(['auth', 'kasir'])->group(function () {});

Route::get('/cashier', function () {
    return view('cashier');
})->name('cashier');

Route::middleware(['auth', 'owner'])->group(function () {});

Route::get('/pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran.index');
Route::post('/pengeluaran', [PengeluaranController::class, 'store'])->name('pengeluaran.store');
Route::get('/pengeluaran/{pengeluaran}', [PengeluaranController::class, 'show'])->name('pengeluaran.show');
Route::put('/pengeluaran/{pengeluaran}', [PengeluaranController::class, 'update'])->name('pengeluaran.update');
Route::delete('/pengeluaran/{pengeluaran}', [PengeluaranController::class, 'destroy'])->name('pengeluaran.destroy');

Route::resource('menu', MenuController::class);
Route::resource('income', IncomeController::class);
Route::resource('account', AccountController::class);
