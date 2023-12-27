<?php

use App\Http\Controllers\AirtimeProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\KycController;
use App\Http\Controllers\PaystackController;



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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('orders', [OrderController::class, 'index']);
Route::get('orders/{id}', [OrderController::class, 'show']);
Route::post('orders', [OrderController::class, 'store']);
Route::put('orders/{id}', [OrderController::class, 'update']);
Route::delete('orders/{id}', [OrderController::class, 'delete']);

// ----------------------------------------------------
Route::get('Countries', [CountryController::class, 'index']);
Route::get('Countries/{id}', [CountryController::class, 'show']);
Route::post('Countries', [CountryController::class, 'store']);
Route::put('Countries/{id}', [CountryController::class, 'update']);
Route::delete('Countries/{id}', [CountryController::class, 'delete']);
Route::get('CountryByStatus', [CountryController::class, 'CountryByStatus']);
Route::get('isloan', [CountryController::class, 'isloan']);
Route::get('CountryPhoneCode/{id}', [CountryController::class, 'phoneCode']);

// --------------------------------------------------------
Route::get('Operators', [OperatorController::class, 'index']);
Route::get('Operators/{id}', [OperatorController::class, 'show']);
Route::post('Operators', [OperatorController::class, 'store']);
Route::put('Operators/{id}', [OperatorController::class, 'update']);
Route::delete('Operators/{id}', [OperatorController::class, 'delete']);
Route::get('operatorStatus', [OperatorController::class, 'operatorStatus']);
Route::get('operatorByCountry/{id}', [OperatorController::class, 'operatorsByCountry']);

// --------------------------------------------------------
Route::get('ProductCategories', [ProductCategoryController::class, 'index']);
Route::get('ProductCategories/{id}', [ProductCategoryController::class, 'show']);
Route::post('ProductCategories', [ProductCategoryController::class, 'store']);
Route::put('ProductCategories/{id}', [ProductCategoryController::class, 'update']);
Route::delete('ProductCategories/{id}', [ProductCategoryController::class, 'delete']);
Route::get('ProductCategoriesStatus', [ProductCategoryController::class, 'ProductCategoryStatus']);
Route::get('ProductCategoriesByOperator/{id}', [ProductCategoryController::class, 'ProductCategoryByOperator']);

// --------------------------------------------------------
Route::get('Products', [ProductController::class, 'index']);
Route::get('Products/{id}', [ProductController::class, 'show']);
Route::post('Products', [ProductController::class, 'store']);
Route::put('Products/{id}', [ProductController::class, 'update']);
Route::delete('Products/{id}', [ProductController::class, 'delete']);
Route::get('ProductByStatus', [ProductController::class, 'ProductByStatus']);
Route::get('getProductById/{id}', [ProductController::class, 'getProductById']);
Route::get('ProductByOperator/{id}', [ProductController::class, 'ProductByOperator']);
Route::get('ProductByCategory/{id}', [ProductController::class, 'ProductByCategory']);
Route::get('getProductByPhone/{id}', [ProductController::class, 'getProductByPhone']);
Route::get('AirtimeProductByCategory/{id}', [AirtimeProductController::class, 'AirtimeProductByCategory']);
Route::get('AirtimeProductByOperator/{id}', [AirtimeProductController::class, 'AirtimeProductByOperator']);

Route::get('/check_recurring', [PaystackController::class, 'checkRecurring']);

Route::get('/createData', [DataController::class, 'createData']);
Route::get('/findUser', [DataController::class, 'findUser']);
Route::get('/token', [DataController::class, 'token']);
Route::post('/verify_bvn', [KycController::class, 'verify_bvn']);

// ---------------------------- PAYMENT AND VERIFICATIONS ------------------------
Route::post('/funds', [PaystackController::class, 'processPayment']);
Route::get('/postpayment_callback.php', [PaystackController::class, 'verfifyPayment']);
Route::post('/verifyWebhookPayment', [PaystackController::class, 'verifyWebhookPaystack']);
