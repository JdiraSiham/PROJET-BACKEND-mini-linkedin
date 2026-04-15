<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;

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

// Auth
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);
});

Route::middleware('auth:api')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::get('/me',      [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    // Profil candidat
    Route::middleware('role:candidat')->prefix('profil')->group(function () {
        Route::post('/',                           [ProfilController::class, 'store']);
        Route::get('/',                            [ProfilController::class, 'show']);
        Route::put('/',                            [ProfilController::class, 'update']);
        Route::post('/competences',                [ProfilController::class, 'addCompetence']);
        Route::delete('/competences/{competence}', [ProfilController::class,
'removeCompetence']);
    });

});
