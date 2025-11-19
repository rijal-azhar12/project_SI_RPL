<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\IncomeController;

// Route::get('/', function () {
//     return view('login');
// });

// Route::get('/', [MenuController::class, 'index'])->name('menu.index');

// Route::get('/', [PengeluaranController::class, 'index'])->name('expense.index');


// Grup middleware auth ini SEKARANG KOSONG. 
// Ini tidak apa-apa, atau Anda bisa hapus jika tidak ada rute lain di dalamnya.
Route::middleware(['auth'])->group(function () {
    
    // Rute 'pendapatan' SUDAH DIPINDAHKAN KELUAR dari blok ini

});

/*Route::get('/', function () {
    return redirect('/accounts');
});*/

// Route::get('/', function () {
//     return redirect('/cashier');
// });

// Route::get('/cashier', function () {
//     return view('cashier_food');
// })->name('cashier');

// --- RUTE ANDA YANG TIDAK DIPROTEKSI ---


// Rute untuk menampilkan halaman pendapatan (GET)
Route::get('/pendapatan', [IncomeController::class, 'index'])->name('pendapatan.index');

// Rute untuk menghapus data (DELETE)
Route::delete('/pendapatan/{id_detail}', [IncomeController::class, 'destroy'])->name('pendapatan.destroy');
// --- BATAS PEMINDAHAN ---

Route::get('/pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran.index');
Route::post('/pengeluaran', [PengeluaranController::class, 'store'])->name('pengeluaran.store');
Route::get('/pengeluaran/{pengeluaran}', [PengeluaranController::class, 'show'])->name('pengeluaran.show');
Route::put('/pengeluaran/{pengeluaran}', [PengeluaranController::class, 'update'])->name('pengeluaran.update');
Route::delete('/pengeluaran/{pengeluaran}', [PengeluaranController::class, 'destroy'])->name('pengeluaran.destroy');

Route::resource('accounts', AccountController::class);
Route::resource('menu', MenuController::class);