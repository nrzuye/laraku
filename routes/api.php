<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources(['user' => 'API\userController']);

// Route::middleware('auth:api')->get('/customer', function (Request $request) {
//     return $request->customer();
// });

Route::apiResources(['customer' => 'API\CustomerController']);
Route::apiResources(['productunit' => 'API\ProductUnitController']);
Route::apiResources(['paket' => 'API\PaketController']);

