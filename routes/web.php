<?php
use Illuminate\Support\Facades\Route;

// Arahkan halaman root utama sementara ke endpoint orders
Route::get('/', function () {
    return redirect('/orders');
});