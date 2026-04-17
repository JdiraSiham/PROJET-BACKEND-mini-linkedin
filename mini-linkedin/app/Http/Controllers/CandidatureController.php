<?php

namespace App\Http\Controllers;

use App\Events\CandidatureDeposee;
use App\Events\StatutCandidatureMis;
use App\Models\Candidature;
use App\Models\Offre;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CandidatureController extends Controller
{
    private function user()
    {
        return Auth::guard('api')->user();
    }

    public function candidater(Request $request, Offre $offre): JsonResponse
    {
        $user = $this->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $profil = $user->profil;

        if (!$profil) {
            return response()->json([
                'error' => 'Vous devez créer un profil avant de postuler.'
            ], 422);
        }

        $dejaPostule = Candidature::where('offre_id', $offre->id)
            ->where('profil_id', $profil->id)
            ->exists();

        if ($dejaPostule) {
            return response()->json([
                'error' => 'Vous avez déjà postulé à cette offre.'
            ], 422);
        }

        $candidature = Candidature::create([
            'offre_id'  => $offre->id,
            'profil_id' => $profil->id,
            'message'   => $request->message,
            'statut'    => 'en_attente',
        ]);

        event(new CandidatureDeposee($candidature->load('profil.user', 'offre')));

        return response()->json([
            'message' => 'Candidature soumise.',
            'candidature' => $candidature
        ], 201);
    }

    public function mesCandidatures(): JsonResponse
    {
        $profil = $this->user()?->profil;

        if (!$profil) {
            return response()->json(['error' => 'Profil introuvable.'], 404);
        }

        return response()->json(
            $profil->candidatures()->with('offre')->get()
        );
    }

    public function candidaturesOffre(Offre $offre): JsonResponse
    {
        if ($offre->user_id !== $this->user()->id) {
            return response()->json(['error' => 'Accès interdit.'], 403);
        }

        return response()->json(
            $offre->candidatures()->with('profil.user')->get()
        );
    }

    public function updateStatut(Request $request, Candidature $candidature): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'statut' => 'required|in:en_attente,acceptee,refusee',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($candidature->offre->user_id !== $this->user()->id) {
            return response()->json(['error' => 'Accès interdit.'], 403);
        }

        $ancienStatut = $candidature->statut;

        $candidature->update([
            'statut' => $request->statut
        ]);

        event(new StatutCandidatureMis(
            $candidature,
            $ancienStatut,
            $request->statut
        ));

        return response()->json([
            'message' => 'Statut mis à jour.',
            'candidature' => $candidature
        ]);
    }
}
