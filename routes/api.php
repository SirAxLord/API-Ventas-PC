<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ServiceController;

Route::prefix('v1')->middleware('throttle:api')->group(function () {
	// Rutas públicas de lectura
	Route::apiResource('products', ProductController::class)->only(['index','show']);
	Route::apiResource('services', ServiceController::class)->only(['index','show']);

	// Rutas protegidas (creación / actualización / eliminación)
	Route::middleware(['auth:sanctum','can:admin'])->group(function () {
		Route::apiResource('products', ProductController::class)->only(['store','update','destroy']);
		Route::apiResource('services', ServiceController::class)->only(['store','update','destroy']);
		Route::post('auth/logout', [AuthController::class, 'logout']);

		// Perfil autenticado
		Route::get('auth/me', [AuthController::class, 'me']);

		// Rutas solo admin (ya cubiertas por can:admin en grupo)
		Route::get('users', [UserController::class, 'index']);
		Route::patch('users/{user}/role', [UserController::class, 'updateRole']);
	});

	// Auth pública para obtener token
	Route::post('auth/login', [AuthController::class, 'login']);
	Route::post('auth/register', [AuthController::class, 'register']);
});