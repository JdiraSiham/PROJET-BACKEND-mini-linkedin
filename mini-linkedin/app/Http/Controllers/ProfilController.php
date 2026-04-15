<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfilController extends Controller
{
    private function user()
    {
        return Auth::guard('api')->user();
    }

    // POST /api/profil
    public function store(Request $request): JsonResponse
    {
        $user = $this->user();

        if ($user->profil) {
            return response()->json(['error' => 'Vous avez déjà un profil.'], 422);
        }

        $validator = Validator::make($request->all(), [
            'titre'        => 'required|string|max:255',
            'bio'          => 'nullable|string',
            'localisation' => 'nullable|string',
            'disponible'   => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $profil = $user->profil()->create($request->only('titre', 'bio', 'localisation', 'disponible'));

        return response()->json(['message' => 'Profil créé.', 'profil' => $profil], 201);
    }

    // GET /api/profil
    public function show(): JsonResponse
    {
        $profil = $this->user()->profil;

        if (! $profil) {
            return response()->json(['error' => 'Profil introuvable.'], 404);
        }

        return response()->json($profil->load('competences'));
    }

    // PUT /api/profil
    public function update(Request $request): JsonResponse
    {
        $profil = $this->user()->profil;

        if (! $profil) {
            return response()->json(['error' => 'Profil introuvable.'], 404);
        }

        $profil->update($request->only('titre', 'bio', 'localisation', 'disponible'));

        return response()->json(['message' => 'Profil mis à jour.', 'profil' => $profil]);
    }

    // POST /api/profil/competences
    public function addCompetence(Request $request): JsonResponse
    {
        $profil = $this->user()->profil;

        if (! $profil) {
            return response()->json(['error' => 'Profil introuvable.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'competence_id' => 'required|exists:competences,id',
            'niveau'        => 'required|in:débutant,intermédiaire,expert',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $profil->competences()->syncWithoutDetaching([
            $request->competence_id => ['niveau' => $request->niveau]
        ]);

        return response()->json(['message' => 'Compétence ajoutée.']);
    }

    // DELETE /api/profil/competences/{competence}
    public function removeCompetence(int $competenceId): JsonResponse
    {
        $profil = $this->user()->profil;

        if (! $profil) {
            return response()->json(['error' => 'Profil introuvable.'], 404);
        }

        $profil->competences()->detach($competenceId);

        return response()->json(['message' => 'Compétence retirée.']);
    }
}
