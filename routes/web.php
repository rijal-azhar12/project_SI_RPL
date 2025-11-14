<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AuthController; // Import AuthController

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect root to login if not authenticated, or to appropriate dashboard
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->peran === 'kasir') {
            return redirect('/kasir');
        } elseif (Auth::user()->peran === 'owner') {
            return redirect('/account');
        }
    }
    return redirect('/login');
});

// Kasir Routes (protected by 'kasir' middleware)
Route::middleware(['auth', 'kasir'])->group(function () {
    Route::get('/kasir', function () {
        return view('kasir'); // Assuming 'kasir.blade.php' exists
    })->name('kasir');
});

// Owner Routes (protected by 'owner' middleware)
Route::middleware(['auth', 'owner'])->group(function () {
    Route::get('/pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran.index');
    Route::post('/pengeluaran', [PengeluaranController::class, 'store'])->name('pengeluaran.store');
    Route::get('/pengeluaran/{pengeluaran}', [PengeluaranController::class, 'show'])->name('pengeluaran.show');
    Route::put('/pengeluaran/{pengeluaran}', [PengeluaranController::class, 'update'])->name('pengeluaran.update');
    Route::delete('/pengeluaran/{pengeluaran}', [PengeluaranController::class, 'destroy'])->name('pengeluaran.destroy');

    Route::resource('accounts', AccountController::class);
    Route::resource('menu', MenuController::class);

    // Assuming 'pemasukan' is a view or handled by a controller
    Route::get('/pemasukan', function () {
        return view('pemasukan'); // Assuming 'pemasukan.blade.php' exists
    })->name('pemasukan');
});
