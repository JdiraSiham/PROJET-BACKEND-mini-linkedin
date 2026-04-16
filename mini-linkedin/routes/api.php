<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\OffreController;
use App\Http\Controllers\CandidatureController;
// Public
Route::get('/offres', [OffreController::class, 'index']);
Route::get('/offres/{offre}',[OffreController::class, 'show']);
// Auth
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});
Route::middleware('auth:api')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
    Route::middleware('role:candidat')->prefix('profil')->group(function () {
        Route::post('/', [ProfilController::class, 'store']);
        Route::get('/', [ProfilController::class, 'show']);
        Route::put('/', [ProfilController::class, 'update']);
        Route::post('/competences', [ProfilController::class, 'addCompetence']);
        Route::delete('/competences/{competence}', [ProfilController::class,
            'removeCompetence']);
    });
    Route::middleware('role:recruteur')->group(function () {
        Route::post('/offres', [OffreController::class, 'store']);
        Route::put('/offres/{offre}', [OffreController::class, 'update']);
        Route::delete('/offres/{offre}', [OffreController::class, 'destroy']);
        Route::get('/offres/{offre}/candidatures', [CandidatureController::class,
            'candidaturesOffre']);
        Route::patch('/candidatures/{candidature}/statut', [CandidatureController::class,
            'updateStatut']);
    });
    Route::middleware('role:candidat')->group(function () {
        Route::post('/offres/{offre}/candidater', [CandidatureController::class, 'candidater']);
        Route::get('/mes-candidatures', [CandidatureController::class,
            'mesCandidatures']);
    });
    // ADMIN
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/users', [AdminController::class, 'users']);
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser']);
        Route::patch('/offres/{offre}',[AdminController::class, 'toggleOffre']);
    });
});
