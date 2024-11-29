<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use \Illuminate\Routing\Middleware\SubstituteBindings; // Resolver parámetros en las rutas
use Fruitcake\Cors\HandleCors;

use App\Http\Controllers\AuthController;


Route::get('/', function () {
    return response()->json("Welcome to MarketplaceApi");
});

//Rutas login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);