<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerShopController;
use Illuminate\Support\Facades\Route;

// ================================================================
// RUTE PUBLIK & CUSTOMER SHOP (Resto 3D)
// ================================================================
Route::get('/', [CustomerShopController::class, 'index'])->name('customer.shop');

// Autentikasi Customer & Admin
Route::get('/login', [AuthController::class, 'showCustomerLogin'])->name('customer.login');
Route::post('/login', [AuthController::class, 'customerLogin']);
Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Terproteksi Customer
Route::middleware('customer.auth')->group(function () {
Route::post('/cart/add', [CustomerShopController::class, 'addToCart'])->name('customer.cart.add');
Route::get('/cart', [CustomerShopController::class, 'cart'])->name('customer.cart');
Route::delete('/cart/{id}', [CustomerShopController::class, 'removeFromCart'])->name('customer.cart.remove');
Route::get('/checkout', [CustomerShopController::class, 'checkout'])->name('customer.checkout');
Route::post('/checkout', [CustomerShopController::class, 'processCheckout'])->name('customer.checkout.process');
Route::get('/order/{id}/qris', [CustomerShopController::class, 'qrisPayment'])->name('customer.qris');
Route::post('/order/{id}/qris/confirm', [CustomerShopController::class, 'confirmQris'])->name('customer.qris.confirm');
Route::get('/orders-history', [CustomerShopController::class, 'myOrders'])->name('customer.orders');
Route::get('/review/{menu_id}', [CustomerShopController::class, 'addReview'])->name('customer.review');
Route::post('/review', [CustomerShopController::class, 'storeReview'])->name('customer.review.store');
Route::get('/feedback', [CustomerShopController::class, 'addFeedback'])->name('customer.feedback');
Route::post('/feedback', [CustomerShopController::class, 'storeFeedback'])->name('customer.feedback.store');
Route::post('/promo/validate', [CustomerShopController::class, 'validatePromo'])->name('customer.promo.validate');
});

// ================================================================
// PANEL MANAJEMEN ADMIN (Terproteksi Middleware admin.auth)
// ================================================================
Route::middleware('admin.auth')->prefix('admin')->group(function () {
// Dashboard Utama redirect ke orders
Route::get('/', function () {
    return redirect()->route('orders.index');
});

// 15 MVC Resources
Route::resource('customers', CustomerController::class);
Route::resource('menus', MenuController::class);
Route::get('orders/status/{status}', [OrderController::class, 'getByStatus'])->name('orders.status');
Route::resource('orders', OrderController::class);
Route::resource('carts', CartController::class);
Route::resource('feedbacks', FeedbackController::class);
Route::resource('categories', CategoryController::class);
Route::resource('suppliers', SupplierController::class);
Route::resource('payments', PaymentController::class);
Route::resource('tables', TableController::class);
Route::resource('reservations', ReservationController::class);
Route::resource('promos', PromoController::class);
Route::resource('reviews', ReviewController::class);
Route::resource('employees', EmployeeController::class);
Route::resource('inventories', InventoryController::class);
Route::resource('branches', BranchController::class);
});

// Rute pembantu untuk mereset dan memigrasi database via browser
Route::get('/dev/migrate-fresh', function() {
try {
    \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--seed' => true]);
    return "<h3>Migrasi & Seeding Berhasil!</h3><p>Database uas_restoran telah direset dan diisi data awal lengkap.</p><pre>" . \Illuminate\Support\Facades\Artisan::output() . "</pre><br><a href='" . route('customer.shop') . "'>Kembali ke Beranda</a>";
} catch (\Exception $e) {
    return "<h3>Terjadi Kesalahan:</h3><pre>" . $e->getMessage() . "</pre>";
}
});