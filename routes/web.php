<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\File;

Route::get('/', [LandingController::class, 'index'])->name('landing');

// Servir OpenAPI YAML desde docs/openapi.yaml con content-type adecuado
Route::get('/docs/openapi.yaml', function () {
	$path = base_path('docs/openapi.yaml');
	abort_unless(File::exists($path), 404);
	return response(File::get($path), 200, [
		'Content-Type' => 'text/yaml; charset=utf-8',
	]);
})->name('openapi.yaml');

// Descargar la colección de Postman generada (JSON) con cabecera de descarga
Route::get('/docs/postman-collection', function () {
	$path = base_path('docs/API Ventas y Servicios (v1).postman_collection.json');
	abort_unless(File::exists($path), 404);
	return response(File::get($path), 200, [
		'Content-Type' => 'application/json; charset=utf-8',
		'Content-Disposition' => 'attachment; filename="API-Ventas-PC.postman_collection.json"',
	]);
})->name('postman.collection.download');

// (Docs/Redoc eliminados; mantenemos sólo la landing visual)
