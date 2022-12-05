<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MsAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;

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


Route::group(['prefix' => 'admin-dashboard'], function () {
    app()->setLocale('ar');
    Route::post('login', [MsAuthController::class, 'login']);
    Route::post('logout', [MsAuthController::class, 'logout']);
    Route::group(
        ['middleware' => ['admin_api_auth']],
        function () {
        }
    );
});


Route::group(['prefix' => 'admin-dashboard', 'middleware'], function () {

    Route::get('list-sub-categories', [Api\SubCatogeryController::class, 'list']);
    Route::resource('sub-categories', Api\SubCatogeryController::class);
    Route::resource('sub-sub-categories', Api\SubSubCategoryController::class);
    Route::resource('customers', Api\CustomerController::class);
    Route::resource('products', Api\ProductController::class);
    Route::resource('categories', Api\CategoryController::class);
    Route::resource('orders', Api\OrderController::class);
    Route::resource('orderstatus', Api\OrderStatuController::class);
    Route::resource('abouts', Api\AboutController::class);
    Route::get('statistics-dashborad', [Api\StatisticsController::class, 'statisticsHomeDashborad']);
    Route::get('report-customers', [Api\ReportController::class, 'reportCustomer']);
    Route::get('report-products', [Api\ReportController::class, 'reportProduct']);

    Route::get('/migrate', function () {
        Artisan::call('migrate', array('--force' => true));
        return "Migrating Is Done";
    });
});
