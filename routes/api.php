<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::prefix('v1')->namespace('V1')->group(function () {
    Route::get('test', 'TestController@test');

    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('login', 'AuthController@login')->name('login');
    });

    Route::apiResource('users', 'UserController')->only(['store']);

    Route::middleware('auth:api')->group(function () {
        Route::prefix('users')->name('users.')->group(function() {
            Route::post('visit', 'UserController@visit')->name('visit');
            Route::delete('', 'UserController@destroy')->name('destroy');
            Route::post('credit-card', 'UserController@creditCard')->name('credit-card');
        });

        Route::apiResource('categories', 'CategoryController')->only(['index', 'show']);
        Route::get('products/recommendation', 'ProductController@recommendation');
        Route::apiResource('products', 'ProductController')->only(['index', 'show']);
        Route::apiResource('transactions', 'TransactionController')->only(['index', 'show', 'store', 'destroy']);
        Route::apiResource('product-comments', 'ProductCommentController')->only(['index', 'show', 'store', 'destroy']);
    });
});
