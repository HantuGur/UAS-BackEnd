<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerShopController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\EmployeeController;

// RUTE PUBLIK
Route::get('/', [CustomerShopController::class, 'index'])->name('customer.shop');

// Autentikasi
Route::get('/login', [AuthController::class, 'showCustomerLogin'])->name('customer.login');
Route::post('/login', [AuthController::class, 'customerLogin']);
Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Customer (login diperlukan)
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

// Admin Panel (login karyawan diperlukan)
Route::middleware('admin.auth')->prefix('admin')->group(function () {
    Route::get('/', fn() => redirect()->route('orders.index'));
    Route::resource('orders', OrderController::class);
    Route::get('orders/status/{status}', [OrderController::class, 'getByStatus'])->name('orders.status');
    Route::resource('categories', CategoryController::class);
    Route::resource('menus', MenuController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('inventories', InventoryController::class);
    Route::resource('tables', TableController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('reservations', ReservationController::class);
    Route::resource('promos', PromoController::class);
    Route::resource('reviews', ReviewController::class);
    Route::resource('feedbacks', FeedbackController::class);
    Route::resource('branches', BranchController::class);
    Route::resource('employees', EmployeeController::class);
});