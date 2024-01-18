<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PharmacyController;

Route::get('/', function () {
    return redirect('/admin/products');
});

Auth::routes();

Route::prefix('admin')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::resource('products', ProductController::class);
    Route::get('show-product/{product}', [ProductController::class, 'show']);
    Route::get('search', [ProductController::class, 'search'])->name('products.search');
    Route::post('get-pharmacies/attach-product/{product}', [ProductController::class, 'attachProduct']);

    Route::resource('pharmacies', PharmacyController::class);
    Route::get('/get-pharmacies/{product}', [PharmacyController::class, 'getPharmacies'])->name('get-pharmacies');

    // Transaltions route for React component
    Route::get('/locale/{type}', function ($type) {
        $translations = trans($type);
        return response()->json($translations);
    });
});
