<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ServiceController;

Route::prefix('v1')->group(function () {
	// Rutas públicas de lectura
	Route::apiResource('products', ProductController::class)->only(['index','show']);
	Route::apiResource('services', ServiceController::class)->only(['index','show']);

	// Rutas protegidas (creación / actualización / eliminación)
	Route::middleware('auth:sanctum')->group(function () {
		Route::apiResource('products', ProductController::class)->only(['store','update','destroy']);
		Route::apiResource('services', ServiceController::class)->only(['store','update','destroy']);
		Route::post('auth/logout', [AuthController::class, 'logout']);
	});

	// Auth pública para obtener token
	Route::post('auth/login', [AuthController::class, 'login']);
});