<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ServiceController;

Route::prefix('v1')->group(function () {
	Route::apiResource('products', ProductController::class);
	Route::apiResource('services', ServiceController::class);
});