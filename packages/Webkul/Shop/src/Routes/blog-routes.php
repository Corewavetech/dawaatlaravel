<?php

use Illuminate\Support\Facades\Route;
use Webkul\Shop\Http\Controllers\BlogsController;

Route::group(['middleware' => ['locale', 'theme', 'currency']], function(){

    Route::prefix('blogs')->group(function() {

        Route::controller(BlogsController::class)->group(function(){

            Route::get('', 'index')->name('shop.blogs.index');
            Route::get('{url}', 'view_blog')->name('shop.blogs.view');

            Route::post('/post-comment', 'post_comment')->name('shop.blog.postComment');

        });

    });

});