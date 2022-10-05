<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__ . '/frontend.php';

require __DIR__ . '/seller.php';

require __DIR__ . '/backend.php';

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('api/save-subscription/{id}',function($id, \Illuminate\Http\Request $request){
    $user = \App\Models\User::findOrFail($id);

    $user->updatePushSubscription($request->input('endpoint'), $request->input('keys.p256dh'), $request->input('keys.auth'));
    $user->notify(new \App\Notifications\GenericNotification("Welcome To GG-Trade", "You will now get all of our notifications"));
    return response()->json([
        'success' => true
    ]);
});

Route::post('api/send-notification/{id}', function($id, Request $request){
    $user = \App\Models\User::findOrFail($id);
    $user->notify(new \App\Notifications\GenericNotification($request->title, $request->body));
    return response()->json([
        'success' => true
    ]);
});

Route::post('api/disable-notification', [\App\Http\Controllers\Frontend\IndexController::class, 'disableNotify'])->name('disable.notification');

Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);

Route::post('currency_load', [\App\Http\Controllers\CurrencyController::class, 'currencyLoad'])->name('currency.load');

Auth::routes(['register'=>false]);
Auth::routes(['verify'=>true]);









