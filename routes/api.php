<?php

use App\Http\Controllers\Api\ExpendCategoriesController;
use App\Http\Controllers\Api\ExpendTransactionsController;
use App\Http\Controllers\Api\IncomeCategoriesController;
use App\Http\Controllers\Api\IncomeTransactionsController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\StatisticsController;
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
        'prefix' => 'statistics'
    ], static function () {
    Route::get('general',[StatisticsController::class,'getGeneralInformation'])
        ->name('statistics.get-general-information');
    Route::get('period',[StatisticsController::class,'getStatisticPeriod'])
        ->name('statistics.get-statistic-period');
    Route::get('category/{type}',[StatisticsController::class,'getTypeTransactionInCategory']);
});


Route::group(
    [
        'middleware' => 'auth:sanctum',
        'prefix' => 'income'
    ], static function () {
    // Расход
    Route::resource('categories', IncomeCategoriesController::class, ['as' => 'income']);
    Route::get('active/categories', [IncomeCategoriesController::class,'indexUserCategory']);
    Route::resource('transactions', IncomeTransactionsController::class, ['as' => 'income']);
});

Route::group(
    [
        'middleware' => 'auth:sanctum',
        'prefix' => 'expend'
    ], static function () {
    // Доход
    Route::resource('categories', ExpendCategoriesController::class, ['as' => 'expend']);
    Route::get('active/categories', [ExpendCategoriesController::class,'indexUserCategory']);
    Route::resource('transactions', ExpendTransactionsController::class, ['as' => 'expend']);
});

Route::group(
    [
        'middleware' => 'auth:sanctum',
        'prefix' => 'user'
    ], static function () {
    // Доход
    Route::resource('settings', SettingsController::class, ['as' => 'settings'])
        ->only('index','update');
});

