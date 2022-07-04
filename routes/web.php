<?php

use App\Http\Controllers\UrlController;

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

Route::get('/', 'UrlController@index');

Route::prefix('urls')->group(function () {
    Route::post('/store',[UrlController::class,'store'])->name('urls.store');
    Route::get('/{url}',[UrlController::class,'show'])->name('urls.show')->where(['url' => '[A-Z]+']);
});
Route::get('/{url}',[UrlController::class,'visit'])->where(['url' => '[A-Z]+']);
