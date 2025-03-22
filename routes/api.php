<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupermarketController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductsCategoryController;
use App\Http\Controllers\AdminAuthController;

Route::post('/admin/login', [AdminAuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
Route::post('/admin/logout', [AdminAuthController::class, 'logout']);
Route::apiResource('/supermarkets', SupermarketController::class);
Route::apiResource('/locations', LocationController::class);
Route::apiResource('/suppliers', SupplierController::class);
Route::apiResource('/products', ProductController::class);
Route::apiResource('/product-categories', ProductsCategoryController::class);
});




