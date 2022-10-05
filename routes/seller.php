<?php

use Illuminate\Support\Facades\Route;

// Seller dashboard

Route::group(['prefix' =>'seller'], function(){

    Route::post('/withdraw', [\App\Http\Controllers\Seller\SellerController::class, 'withdraw'])->name('withdraw.request');


    // Product section
    Route::resource('/seller-product',\App\Http\Controllers\Seller\ProductController::class);
    Route::post('seller_product_status',[\App\Http\Controllers\Seller\ProductController::class, 'productStatus'])->name('seller.product.status');
    Route::post('seller_terms',[\App\Http\Controllers\Seller\ProductController::class, 'sellerTerms'])->name('seller.terms');
    Route::post('/new-offer/{id}',[\App\Http\Controllers\Seller\ProductController::class, 'newOffer'])->name('post.new.offer');


    Route::resource('/orders', \App\Http\Controllers\Seller\OrderController::class);
    Route::post('/orders-status', [\App\Http\Controllers\Seller\OrderController::class, 'orderStatus'])->name('orders.status');



    Route::get('/settings', [\App\Http\Controllers\Seller\SellerController::class, 'settings'])->name('seller.settings');
    Route::post('/settings-upd', [\App\Http\Controllers\Seller\SellerController::class, 'settingsUpdate'])->name('seller.settings.update');


});

Route::group(['prefix' => 'filemanager', 'middleware'=> ['web']], function (){
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::get('/shop/{slug}', [\App\Http\Controllers\Seller\SellerController::class, 'sellerShop'])->name('seller.shop');

