<?php
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Redirect dari halaman utama root (/) langsung menuju ke halaman pesanan (orders)
Route::get('/', function () {
    return redirect()->route('orders.index');
});

// Route Resource Web untuk Pelanggan (Customers)
Route::resource('customers', CustomerController::class);

// Route Resource Web untuk Menu Makanan/Minuman
Route::resource('menus', MenuController::class);

// Route Web khusus untuk menyaring pesanan berdasarkan status (pending/completed)
Route::get('orders/status/{status}', [OrderController::class, 'getByStatus'])->name('orders.status');

// Route Resource Web untuk Pesanan (Orders)
Route::resource('orders', OrderController::class);