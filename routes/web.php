<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\SellerOrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini adalah tempat Anda mendaftarkan semua route untuk aplikasi Anda.
|
*/

// == HALAMAN PUBLIK ==
// Route untuk halaman utama (homepage) aplikasi
Route::get('/', [ProductController::class, 'index'])->name('home');


// == HALAMAN YANG MEMERLUKAN LOGIN ==
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Manajemen Produk (milik penjual)
    Route::resource('products', ProductController::class);

    // Keranjang Belanja
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::get('/cart/remove/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // Riwayat Pesanan, Struk, dan Manajemen Status
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/invoice', [OrderController::class, 'showInvoice'])->name('orders.invoice');
    
    // ==> ROUTE BARU UNTUK UPDATE STATUS DITAMBAHKAN DI SINI <==
    Route::post('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update_status');

    Route::post('/orders/{order}/payment', [OrderController::class, 'submitPayment'])->name('orders.payment');

    Route::get('/seller/orders/{order}', [SellerOrderController::class, 'show'])->name('seller.orders.show');



    Route::resource('addresses', AddressController::class);

});


// Memuat route-route autentikasi Laravel bawaan (login, register, dll.)
require __DIR__.'/auth.php';
