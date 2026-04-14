<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
// Routes publiques
Route::prefix('auth')->group(function () {
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);
});
// Routes protégées JWT
Route::middleware('auth:api')->prefix('auth')->group(function () {
Route::get('/me',
[AuthController::class, 'me']);
Route::post('/logout', [AuthController::class, 'logout']);
});
