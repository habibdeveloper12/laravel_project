<?php

use Illuminate\Support\Facades\Route;

Route::post('/payop/webhook',[\App\Http\Controllers\PaymentController::class, 'payop_webhook']);


Route::get('/', [App\Http\Controllers\Frontend\IndexController::class, 'home'])->name('home');

Route::get('legal/cookie', [App\Http\Controllers\Frontend\IndexController::class, 'cookiePolicy'])->name('cookie.policy');
Route::get('legal/privacy', [App\Http\Controllers\Frontend\IndexController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('legal/terms', [App\Http\Controllers\Frontend\IndexController::class, 'termsPolicy'])->name('terms.policy');

Route::get('/support', [App\Http\Controllers\Frontend\IndexController::class, 'support'])->name('support');
Route::get('/support/all', [App\Http\Controllers\Frontend\IndexController::class, 'allSupport'])->name('support.all');
Route::get('/support/article/{slug}', [App\Http\Controllers\Frontend\IndexController::class, 'supportArticle'])->name('support-article');
Route::get('/support/section/{id}', [App\Http\Controllers\Frontend\IndexController::class, 'supportSubSection'])->name('support-sub-section');
Route::post('/support/comment', [App\Http\Controllers\Frontend\IndexController::class, 'postSupportComment'])->name('support.comment.post');
Route::post('/support/helpful', [App\Http\Controllers\Frontend\IndexController::class, 'articleHelpful'])->name('article.helpful');


Route::get('/support/general-questions', [App\Http\Controllers\Frontend\IndexController::class, 'generalQuestion'])->name('general.question');
Route::get('/support/seller-information', [App\Http\Controllers\Frontend\IndexController::class, 'sellerInfo'])->name('seller.information');


Route::get('/support/submit-a-request', [App\Http\Controllers\Frontend\IndexController::class, 'getSubmitRequest'])->name('support.request');
Route::post('/support/submit-a-request', [App\Http\Controllers\Frontend\IndexController::class, 'sendContact'])->name('contact.us');

use Laravel\Socialite\Facades\Socialite;

Route::get('/login/google', [App\Http\Controllers\Frontend\IndexController::class, 'redirectToGoogle'])->name('login.google');

Route::get('/login/google/callback', [App\Http\Controllers\Frontend\IndexController::class, 'handleGoogleCallback']);



//authentication
Route::get('user/login', [App\Http\Controllers\Frontend\IndexController::class, 'userAuth'])->name('user.auth');
Route::post('user/auth',[App\Http\Controllers\Frontend\IndexController::class, 'loginSubmit'])->name('login.submit');

Route::get('/password/forgot',[App\Http\Controllers\Frontend\IndexController::class, 'resetPassword'])->name('reset.password');
Route::post('password/forgot',[App\Http\Controllers\Frontend\IndexController::class, 'resetPasswordLink'])->name('reset.password.link');
Route::get('/user-password/reset/{token}',[App\Http\Controllers\Frontend\IndexController::class, 'showResetForm'])->name('reset.form');
Route::post('/user-password/reset',[App\Http\Controllers\Frontend\IndexController::class, 'passwordReset'])->name('user.password.reset');



Route::get('/verify', [App\Http\Controllers\Frontend\IndexController::class, 'verifyUser'])->name('verify.user');
Route::get('/verify-email', [App\Http\Controllers\Frontend\IndexController::class, 'verifyEmail'])->name('verify.email');


//Registration
Route::get('user/register',[App\Http\Controllers\Frontend\IndexController::class, 'registerUser'])->name('user.register');
Route::post('register/user',[App\Http\Controllers\Frontend\IndexController::class, 'registerSubmit'])->name('register.submit');

Route::get('user/logout',[App\Http\Controllers\Frontend\IndexController::class, 'userLogout'])->name('user.logout');


//product category
Route::get('product-category/{slug}/', [App\Http\Controllers\Frontend\IndexController::class, 'productCategory'])->name('product.category');

//product detail
Route::get('product-detail/{slug}/',  [App\Http\Controllers\Frontend\IndexController::class, 'productDetail'])->name('product.detail');

//
Route::post('user-review', [App\Http\Controllers\UserReviewController::class, 'userReview'])->name('user.review');
Route::post('user-review-update', [App\Http\Controllers\UserReviewController::class, 'userReviewUpdate'])->name('user.review.update');

Route::get('sales',  [App\Http\Controllers\Frontend\IndexController::class, 'userSales'])->name('user.sales');
Route::get('funds',  [App\Http\Controllers\Frontend\IndexController::class, 'userFunds'])->name('user.funds');


//paypal
Route::get('/paypal/payment/cancel', [App\Http\Controllers\PaypalController::class, 'getCancel']);
Route::get('/paypal/payment/done', [App\Http\Controllers\PaypalController::class, 'getDone']);

//checkout
Route::post('payment', [\App\Http\Controllers\Frontend\CheckoutController::class, 'pay'])->name('payment');
Route::post('payment/processing', [\App\Http\Controllers\Frontend\CheckoutController::class, 'paymentProcess'])->name('payment.processing');
Route::post('payment/processing_direct', [\App\Http\Controllers\Frontend\CheckoutController::class, 'paymentProcess2'])->name('payment.processing2');
Route::get('completed', [\App\Http\Controllers\Frontend\CheckoutController::class, 'thanks'])->name('thank.you');
Route::get('fail', [\App\Http\Controllers\Frontend\CheckoutController::class, 'fail'])->name('payment.fail');


Route::get('shop', [\App\Http\Controllers\Frontend\IndexController::class, 'shop'])->name('shop');
Route::post('shop-filter/{cat}/{slug}', [\App\Http\Controllers\Frontend\IndexController::class, 'shopFilter'])->name('shop.filter');
Route::post('shop-server/{cat}/{slug}', [\App\Http\Controllers\Frontend\IndexController::class, 'shopFilterServer'])->name('shop.server');

Route::get('shop-game/{cat}/{slug}', [\App\Http\Controllers\Frontend\IndexController::class, 'shopGames'])->name('shop.games');
Route::get('shop-game/{slug}', [\App\Http\Controllers\Frontend\IndexController::class, 'shopGame'])->name('shop.game');


//search

Route::get('autosearch', [\App\Http\Controllers\Frontend\IndexController::class, 'autoSearch'])->name('autosearch');
Route::get('search', [\App\Http\Controllers\Frontend\IndexController::class, 'search'])->name('search');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);


Route::group(['prefix' =>'user'], function(){
    Route::get('/',[\App\Http\Controllers\Frontend\IndexController::class, 'userDashboard'])->name('user');
    Route::get('/dashboard',[\App\Http\Controllers\Frontend\IndexController::class, 'userDashboard'])->name('user.dashboard');
    Route::get('/become-a-seller',[\App\Http\Controllers\Frontend\IndexController::class, 'bas'])->name('user.bas');
    Route::get('/settings',[\App\Http\Controllers\Frontend\IndexController::class, 'userSettings'])->name('user.settings');
    Route::get('/profile',[\App\Http\Controllers\Frontend\IndexController::class, 'userProfile'])->name('user.profile');
    Route::get('/change-password',[\App\Http\Controllers\Frontend\IndexController::class, 'changePass'])->name('user.changePass');
    Route::get('/address',[\App\Http\Controllers\Frontend\IndexController::class, 'userAddress'])->name('user.address');

    Route::post('/change-email',[\App\Http\Controllers\Frontend\IndexController::class, 'changeEmail'])->name('change.email');

    Route::post('/update/avatar',[\App\Http\Controllers\Frontend\IndexController::class, 'avatarUpdate'])->name('update.avatar');

    Route::post('/change-password/{id}',[\App\Http\Controllers\Frontend\IndexController::class, 'passwordUpdate'])->name('password.updates');

    Route::resource('/message', \App\Http\Controllers\MessageController::class);
    Route::post('/message-post-file',[\App\Http\Controllers\MessageController::class, 'fileMessage'])->name('message.file');
    Route::get('/message-get',[\App\Http\Controllers\MessageController::class, 'fetchMessage'])->name('fetch.message');


    Route::resource('/user-order',\App\Http\Controllers\Frontend\OrderController::class);
    Route::post('/user-order/{id}',[\App\Http\Controllers\Frontend\OrderController::class, 'OrderUpdate'])->name('user-order.update');
    Route::post('/user-order/admin/{id}',[\App\Http\Controllers\Frontend\OrderController::class, 'notifyAdmin'])->name('notify.admin');

});
