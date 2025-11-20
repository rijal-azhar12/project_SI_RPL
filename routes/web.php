<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AuthController;     // PENTING: Dari teman Anda
use App\Http\Controllers\IncomeController;   // PENTING: Punya Anda

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- 1. Authentication Routes (Dari Teman Anda) ---
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- 2. Root Redirect Logic (Dari Teman Anda) ---
// Mengarahkan user berdasarkan peran saat membuka halaman awal
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->peran === 'kasir') {
            return redirect('/kasir'); // Sesuaikan rute kasir
        } elseif (Auth::user()->peran === 'owner') {
            // OPSI: Arahkan owner ke halaman pemasukan atau accounts
            return redirect()->route('pemasukan.index'); 
        }
    }
    return redirect('/login');
});

// --- 3. Kasir Routes ---
Route::middleware(['auth', 'kasir'])->group(function () {
    Route::get('/kasir', function () {
        return view('kasir'); 
    })->name('kasir');
});

// --- 4. Owner Routes ---
// Idealnya, rute Pemasukan & Pengeluaran ada di sini.
// TAPI, karena Login belum siap 100%, saya taruh di luar dulu (Unprotected)
// agar Anda tetap bisa bekerja. Nanti pindahkan ke dalam sini.
Route::middleware(['auth', 'owner'])->group(function () {
    // Pindahkan route di bawah ke sini nanti saat login sudah fix
});


// --- 5. FITUR UTAMA (UNPROTECTED SEMENTARA) ---

// A. Pemasukan / Income (GABUNGAN: Nama rute teman, Logika Anda)
Route::get('/pemasukan', [IncomeController::class, 'index'])->name('pemasukan.index');
Route::delete('/pemasukan/{id_detail}', [IncomeController::class, 'destroy'])->name('pemasukan.destroy');

// B. Pengeluaran
Route::get('/pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran.index');
Route::post('/pengeluaran', [PengeluaranController::class, 'store'])->name('pengeluaran.store');
Route::get('/pengeluaran/{pengeluaran}', [PengeluaranController::class, 'show'])->name('pengeluaran.show');
Route::put('/pengeluaran/{pengeluaran}', [PengeluaranController::class, 'update'])->name('pengeluaran.update');
Route::delete('/pengeluaran/{pengeluaran}', [PengeluaranController::class, 'destroy'])->name('pengeluaran.destroy');

// C. Resource Lainnya
Route::resource('accounts', AccountController::class);
Route::resource('menu', MenuController::class);
