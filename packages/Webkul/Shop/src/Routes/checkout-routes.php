<?php

use Illuminate\Support\Facades\Route;
use Webkul\Shop\Http\Controllers\CartController;
use Webkul\Shop\Http\Controllers\OnepageController;
use Webkul\Shop\Http\Controllers\WishlistController;

Route::group(['middleware' => ['locale', 'theme', 'currency']], function () {
    /**
     * Cart routes.
     */
    Route::controller(CartController::class)->prefix('checkout/cart')->group(function () {
        Route::get('', 'index')->name('shop.checkout.cart.index');
    });

    Route::controller(OnepageController::class)->prefix('checkout/onepage')->group(function () {
        Route::get('', 'index')->name('shop.checkout.onepage.index');

        Route::get('success', 'success')->name('shop.checkout.onepage.success');
    });

    Route::controller(WishlistController::class)->prefix('checkout/wishlist/home')->group(function () {
        Route::get('', 'index')->name('shop.checkout.wishlist.index');
    });

    Route::controller(WishlistController::class)->prefix('checkout/wishlist/update')->group(function () {
        Route::get('', 'update')->name('shop.checkout.wishlist.update');
    });

    Route::controller(WishlistController::class)->prefix('checkout/wishlist/destroy')->group(function () {
        Route::get('', 'destroy')->name('shop.checkout.wishlist.destroy');
    });

});
