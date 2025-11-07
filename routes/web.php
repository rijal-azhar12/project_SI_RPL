<?php

use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('login');
});*/


/*Route::get('/', function () {
    return view('menu_manajement');
});*/


/*Route::get('/', function () {
    return view('expense');
});*/

/*Route::get('/', function () {
    return view('incomes');
});*/

/*Route::get('/', function () {
    return view('account');
});*/

Route::get('/', function () {
    return redirect('/cashier');
});

// Halaman kasir utama sekarang memuat file 'cashier_food'
Route::get('/cashier', function () {
    return view('cashier_food');
})->name('cashier'); // Kita beri nama 'cashier'

// ... (Rute login, dll) ...
