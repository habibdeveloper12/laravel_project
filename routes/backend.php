<?php


use Illuminate\Support\Facades\Route;

Route::group(['prefix'=> 'admin'], function(){
    Route::get('/login', [\App\Http\Controllers\Auth\Admin\LoginController::class, 'showLoginForm'])->name('admin.login.form');
    Route::post('/login', [\App\Http\Controllers\Auth\Admin\LoginController::class, 'login'])->name('admin.login');
});

// Admin dashboard

Route::group(['prefix' =>'admin', 'middleware' => 'admin'], function(){

    Route::get('/',[\App\Http\Controllers\AdminController::class, 'admin'])->name('admin');


    Route::get('/message',[\App\Http\Controllers\AdminController::class, 'indexMessage'])->name('adminMessage');
    Route::get('/message/{id}',[\App\Http\Controllers\AdminController::class, 'showMessage'])->name('showMessage');
    Route::post('/adsmessage',[\App\Http\Controllers\AdminController::class, 'postMessage'])->name('admin.message.store');
    Route::post('/admessage',[\App\Http\Controllers\AdminController::class, 'fileMessage'])->name('admin.message.file');
    Route::post('/avmessage',[\App\Http\Controllers\AdminController::class, 'postedMessage'])->name('admin.message.store.v');
    Route::post('/avdmessage',[\App\Http\Controllers\AdminController::class, 'filedMessage'])->name('admin.message.file.v');




    Route::get('/withdraw',[\App\Http\Controllers\AdminController::class, 'withdraw'])->name('withdraw');
    Route::post('/withdraw',[\App\Http\Controllers\AdminController::class, 'withdrawResponse'])->name('seller.withdraw');


    Route::get('/dispute',[\App\Http\Controllers\AdminController::class, 'dispute'])->name('dispute');
    Route::post('/dispute_status',[\App\Http\Controllers\AdminController::class, 'disputeStatus'])->name('dispute.status');

    Route::get('/rule',[\App\Http\Controllers\AdminController::class, 'rule'])->name('rule');
    Route::get('rule/{id}', [\App\Http\Controllers\AdminController::class, 'showChat'])->name('chat.show');
    Route::get('/add-word',[\App\Http\Controllers\AdminController::class, 'addWord'])->name('add.word');


    Route::post('/postWord',[\App\Http\Controllers\AdminController::class, 'postWord'])->name('post.word');

    Route::post('/edit-word/{id}',[\App\Http\Controllers\AdminController::class, 'editWord'])->name('word.update');
    Route::post('/destroy-word/{id}',[\App\Http\Controllers\AdminController::class, 'deleteWord'])->name('word.destroy');

    Route::get('/announcement',[\App\Http\Controllers\AdminController::class, 'announcement'])->name('announcement');
    Route::post('/announcement-post',[\App\Http\Controllers\AdminController::class, 'postAnnouncement'])->name('post.announcement');



// Catergory section
    Route::resource('/category',\App\Http\Controllers\CategoryController::class);
    Route::post('category_status',[\App\Http\Controllers\CategoryController::class, 'categoryStatus'])->name('category.status');

    Route::post('category/{id}/child', [\App\Http\Controllers\CategoryController::class, 'getChildByParentID']);

    // Brand section
    Route::resource('/brand',\App\Http\Controllers\BrandController::class);
    Route::post('brand_status',[\App\Http\Controllers\BrandController::class, 'brandStatus'])->name('brand.status');

    // Product section
    Route::resource('/product',\App\Http\Controllers\ProductController::class);
    Route::post('product_status',[\App\Http\Controllers\ProductController::class, 'productStatus'])->name('product.status');

    // Product attribute section
    Route::post('product-attribute/{id}',[\App\Http\Controllers\ProductController::class, 'addProductAttribute'])->name('product.attribute');
    Route::delete('product-attribute-delete/{id}',[\App\Http\Controllers\ProductController::class, 'addProductAttributeDelete'])->name('product.attribute.destroy');

    // User section
    Route::resource('/user',\App\Http\Controllers\UserController::class);
    Route::post('user_status',[\App\Http\Controllers\UserController::class, 'userStatus'])->name('user.status');


   // Coupon section
    Route::resource('/coupon',\App\Http\Controllers\CouponController::class);
    Route::post('coupon_status',[\App\Http\Controllers\CouponController::class, 'couponStatus'])->name('coupon.status');

    // Shipping section
    Route::resource('/shipping',\App\Http\Controllers\ShippingController::class);
    Route::post('shipping_status',[\App\Http\Controllers\ShippingController::class, 'shippingStatus'])->name('shipping.status');

    // Shipping section
    Route::resource('/currency',\App\Http\Controllers\CurrencyController::class);
    Route::post('currency_status',[\App\Http\Controllers\CurrencyController::class, 'currencyStatus'])->name('currency.status');

    //Order Section
    Route::resource('order', \App\Http\Controllers\OrderController::class);
    Route::post('order-status',[\App\Http\Controllers\OrderController::class, 'orderStatus'])->name('order.status');


    //Settings Section
    Route::put('settings',[\App\Http\Controllers\SettingsController::class, 'settingsUpdate'])->name('settings.update');
    Route::get('settings',[\App\Http\Controllers\SettingsController::class, 'settings'])->name('settings');


    //Seller Section
    Route::resource('seller', \App\Http\Controllers\SellerController::class);
    Route::post('seller-status',[\App\Http\Controllers\SellerController::class, 'sellerStatus'])->name('seller.status');



    //Payment Section
    Route::get('payment',[\App\Http\Controllers\SettingsController::class, 'payment'])->name('settings.payment');
    Route::patch('paypal-settings-update',[\App\Http\Controllers\SettingsController::class, 'paypalUpdate'])->name('paypal.settings.update');

    //Withdraw settings
    Route::get('withdraw/settings',[\App\Http\Controllers\SettingsController::class, 'withdraw'])->name('settings.withdraw');
    Route::post('withdraw/settings/update',[\App\Http\Controllers\SettingsController::class, 'withdrawUpdate'])->name('settings.withdraw.update');


    //fund management
    Route::get('all/transaction',[\App\Http\Controllers\AdminController::class, 'allPayment'])->name('all.transaction');
    Route::get('fund/manage',[\App\Http\Controllers\AdminController::class, 'payment'])->name('fund.pending');

    Route::post('approve/transaction',[\App\Http\Controllers\AdminController::class, 'approveTransaction'])->name('approve.transaction');
    Route::post('disapprove/transaction',[\App\Http\Controllers\AdminController::class, 'disapproveTransaction'])->name('disapprove.transaction');


});

Route::group(['prefix' => 'filemanager', 'middleware'=> ['web']], function (){
   \UniSharp\LaravelFilemanager\Lfm::routes();
});
