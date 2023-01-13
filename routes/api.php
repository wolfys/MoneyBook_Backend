<?php

use App\Http\Controllers\Api\Core\RegisterController;
use App\Http\Controllers\Api\Handbook\ExpendCategoriesController;
use App\Http\Controllers\Api\Handbook\IncomeCategoriesController;
use App\Http\Controllers\Api\Core\IncomeTransactionsController;
use App\Http\Controllers\Api\Core\ExpendTransactionsController;
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
        'prefix' => 'income'
    ], static function () {
    // Расход
    Route::resource('categories', IncomeCategoriesController::class, ['as' => 'income']);
    Route::resource('transactions', IncomeTransactionsController::class, ['as' => 'income']);
});

Route::group(
    [
        'middleware' => 'auth:sanctum',
        'prefix' => 'expend'
    ], static function () {
    // Доход
    Route::resource('categories', ExpendCategoriesController::class, ['as' => 'expend']);
    Route::resource('transactions', ExpendTransactionsController::class, ['as' => 'expend']);
});

