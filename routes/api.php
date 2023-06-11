<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrderController;
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

Route::get('/import/customers', 'CustomerController@importCustomers');
Route::get('/import/products', 'ProductController@importProducts');

/*
 * Route for Order related
 */
Route::get('/orders', [OrderController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/{id}', [OrderController::class, 'show']);
Route::put('/orders/{id}', [OrderController::class, 'update']);
Route::delete('/orders/{id}', [OrderController::class, 'destroy']);

Route::post('/order/{id}/add', [OrderController::class, 'attachProduct']);
Route::post('/order/{id}/pay', [OrderController::class, 'payOrder']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
