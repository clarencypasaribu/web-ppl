<?php

use App\Http\Controllers\AdminSessionController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PlatformDashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerAuthController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SellerDashboardController;
use App\Http\Controllers\SellerPasswordController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::controller(SellerController::class)->group(function () {
    Route::get('/seller/register', 'create')->name('sellers.register');
    Route::post('/seller/register', 'store')->name('sellers.store');
});

Route::middleware('admin.access')->group(function () {
    Route::get('/seller/verifications', [SellerController::class, 'verificationIndex'])->name('sellers.verifications');
    Route::post('/seller/{seller}/verify', [SellerController::class, 'verify'])->name('sellers.verify');
});

Route::middleware('signed')->group(function () {
    Route::get('/seller/{seller}/password/create', [SellerPasswordController::class, 'create'])->name('sellers.password.create');
    Route::post('/seller/{seller}/password', [SellerPasswordController::class, 'store'])->name('sellers.password.store');
});

Route::get('/platform/dashboard', [PlatformDashboardController::class, 'index'])->name('dashboard.platform');
Route::get('/seller/{seller}/dashboard', [SellerDashboardController::class, 'show'])->name('dashboard.seller');
Route::get('/seller/home', [SellerDashboardController::class, 'home'])->name('seller.home');

Route::resource('categories', CategoryController::class)->only(['store', 'update', 'destroy']);
Route::resource('products', ProductController::class)->except(['show']);

Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');

Route::get('/seller/login', [SellerAuthController::class, 'create'])->name('seller.login');
Route::post('/seller/login', [SellerAuthController::class, 'store'])->name('seller.login.attempt');
Route::post('/seller/logout', [SellerAuthController::class, 'destroy'])->name('seller.logout');

Route::get('/admin/login', [AdminSessionController::class, 'create'])->name('admin.login');
Route::post('/admin/login', [AdminSessionController::class, 'store'])->name('admin.login.store');
Route::post('/admin/logout', [AdminSessionController::class, 'destroy'])
    ->name('admin.logout')
    ->middleware('admin.access');
