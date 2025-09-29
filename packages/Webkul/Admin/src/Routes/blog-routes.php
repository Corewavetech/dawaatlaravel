<?php

use Illuminate\Support\Facades\Route;
use Webkul\Admin\Http\Controllers\SubscriptionPlanController;

Route::group(['middleware' => ['admin'], 'prefix'=>config('app.admin_url')], function(){

    Route::prefix('subsctiption-plan')->group(function(){
        Route::get('plans', [SubscriptionPlanController::class, 'index'])->name('admin.subscription.plans.index');
        Route::get('plans/create', [SubscriptionPlanController::class, 'create'])->name('admin.subscription.plans.create');
        Route::post('plans', [SubscriptionPlanController::class, 'store'])->name('admin.subscription.plans.store');
        Route::get('plans/{plan}/edit', [SubscriptionPlanController::class, 'edit'])->name('admin.subscription.plans.edit');
        Route::post('plans/{plan}', [SubscriptionPlanController::class, 'update'])->name('admin.subscription.plans.update');
        Route::delete('plans/{plan}/delete', [SubscriptionPlanController::class, 'destroy'])->name('admin.subscription.plans.destroy');
        Route::post('plans/delete/Mass', [SubscriptionPlanController::class, 'massDestroy'])->name('admin.subscription.plans.mass.delete');
    });

});