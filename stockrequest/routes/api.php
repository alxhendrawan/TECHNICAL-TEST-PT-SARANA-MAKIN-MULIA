<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockRequestController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource("stock-request", StockRequestController::class);
Route::get("stock-request/header/{id}",[StockRequestController::class,"getHeader"]);
Route::get("stock-request/line/{id}",[StockRequestController::class,"getLine"]);
Route::resource("user", UserController::class);
Route::resource("product", ProductController::class);
