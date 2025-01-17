<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProductController;
use Symfony\Component\HttpFoundation\Response;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return response()->json([
        'success' => 'Seja bem-vindo à nossa API - ABC'
    ]);
});

Route::group(['prefix'=>'sales'], function () {
    Route::get('/', [SaleController::class, 'index']);
});

Route::group(['prefix'=>'sale'], function () {
    $idInThePath = '/{id}';
    Route::get($idInThePath, [SaleController::class, 'show']);
    Route::post('/', [SaleController::class, 'store']);
    Route::post('/{id}/products', [SaleController::class, 'addProduct']);
    Route::put($idInThePath, [SaleController::class, 'update']);
    Route::delete($idInThePath, [SaleController::class, 'destroy']);
});

Route::group(['prefix'=>'products'], function () {
    Route::get('/', [ProductController::class, 'index']);
});
