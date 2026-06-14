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

// RUTE PUBLIK
Route::get('/', [CustomerShopController::class, 'index'])->name('customer.shop');

// Rute Autentikasi
Route::get('/login', [AuthController::class, 'showCustomerLogin'])->name('customer.login');
Route::post('/login', [AuthController::class, 'customerLogin']);
Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Middleware Customer — rute yang membutuhkan login pelanggan
Route::middleware('customer.auth')->group(function () {
    Route::post('/cart/add', [CustomerShopController::class, 'addToCart'])->name('customer.cart.add');
    Route::get('/cart', [CustomerShopController::class, 'cart'])->name('customer.cart');
    Route::delete('/cart/{id}', [CustomerShopController::class, 'removeFromCart'])->name('customer.cart.remove');
    Route::get('/checkout', [CustomerShopController::class, 'checkout'])->name('customer.checkout');
    Route::post('/checkout', [CustomerShopController::class, 'processCheckout'])->name('customer.checkout.process');
    Route::get('/qris/{id}', [CustomerShopController::class, 'qrisPayment'])->name('customer.qris');
    Route::post('/qris/{id}/confirm', [CustomerShopController::class, 'confirmQris'])->name('customer.qris.confirm');
    Route::get('/orders-history', [CustomerShopController::class, 'myOrders'])->name('customer.orders');
    Route::post('/promo/validate', [CustomerShopController::class, 'validatePromo'])->name('customer.promo.validate');
    Route::get('/review/{menu_id}', [CustomerShopController::class, 'addReview'])->name('customer.review.add');
    Route::post('/review', [CustomerShopController::class, 'storeReview'])->name('customer.review.store');
    Route::get('/feedback', [CustomerShopController::class, 'addFeedback'])->name('customer.feedback');
    Route::post('/feedback', [CustomerShopController::class, 'storeFeedback'])->name('customer.feedback.store');
});