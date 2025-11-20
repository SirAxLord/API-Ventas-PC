<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ServiceController;

Route::apiResource('products', ProductController::class);
Route::apiResource('services', ServiceController::class);