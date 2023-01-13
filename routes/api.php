<?php

use App\Http\Controllers\Api\Core\RegisterController;
use App\Http\Controllers\Api\Handbook\ExpendCategoriesController;
use Illuminate\Support\Facades\Route;

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

Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'auth'
    ], static function () {
    Route::post('register', [RegisterController::class, 'register'])->name('register');
    Route::post('login', [RegisterController::class, 'login'])->name('login');
});
Route::group(
    [
        'middleware' => 'auth:sanctum',
        'prefix' => 'handbook'
    ], static function () {
    Route::resource('expend-categories',ExpendCategoriesController::class);
});
