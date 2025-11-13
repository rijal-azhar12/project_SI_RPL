<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\MenuController;

// Route::get('/', function () {
//     return view('login');
// });

// Route::get('/', [MenuController::class, 'index'])->name('menu.index');

// Route::get('/', [PengeluaranController::class, 'index'])->name('expense.index');

Route::get('/', function () {
    return view('incomes');
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

Route::get('/pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran.index');
Route::post('/pengeluaran', [PengeluaranController::class, 'store'])->name('pengeluaran.store');
Route::get('/pengeluaran/{pengeluaran}', [PengeluaranController::class, 'show'])->name('pengeluaran.show');
Route::put('/pengeluaran/{pengeluaran}', [PengeluaranController::class, 'update'])->name('pengeluaran.update');
Route::delete('/pengeluaran/{pengeluaran}', [PengeluaranController::class, 'destroy'])->name('pengeluaran.destroy');

Route::resource('accounts', AccountController::class);
Route::resource('menu', MenuController::class);