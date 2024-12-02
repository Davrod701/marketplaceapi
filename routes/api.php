<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use \Illuminate\Routing\Middleware\SubstituteBindings; // Resolver parámetros en las rutas
use Fruitcake\Cors\HandleCors;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;


Route::get('/', function () {
    return response()->json("Welcome to MarketplaceApi");
});

//Rutas login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);


Route::get('/productos', [ProductoController::class, 'index']);
Route::get('/productos/{id}', [ProductoController::class, 'show']);
Route::post('/productos', [ProductoController::class, 'store']);
Route::put('/productos/{id}', [ProductoController::class, 'update']);


Route::apiResource('chats', ChatController::class);





Route::get('chats/{chatId}/messages', [MessageController::class, 'index']); // Obtener los mensajes de un chat
Route::post('messages', [MessageController::class, 'store']); // Crear un nuevo mensaje
Route::get('messages/{id}', [MessageController::class, 'show']); // Mostrar un mensaje específico
Route::put('messages/{id}', [MessageController::class, 'update']); // Actualizar un mensaje
Route::delete('messages/{id}', [MessageController::class, 'destroy']); // Eliminar un mensaje