<?php

use Illuminate\Support\Facades\Route;
use Webkul\Shop\Http\Controllers\SubscriptionPlanStoreController;

Route::group(['middleware' => ['locale', 'theme', 'currency']], function(){

    Route::prefix('subscriptions')->group(function(){
       
        Route::controller(SubscriptionPlanStoreController::class)->prefix('plans')->group(function(){

            Route::get('', 'index')->name('shop.subscriptions.plans.index');
            Route::get('/checkout', 'checkout')->name('shop.subscription.checkout');            
            Route::get('/payment', 'paymentPage')->name('shop.subscription.payment');
            Route::post('/payment/process', 'processPayment')->name('shop.subscription.payment.process');
        });
        
    });

});