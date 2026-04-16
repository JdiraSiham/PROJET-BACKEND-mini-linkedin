<?php
namespace App\Http\Controllers;
use App\Models\Offre;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class AdminController extends Controller
{
    public function users(): JsonResponse
    {
        return response()->json(User::all());
    }
    public function deleteUser(User $user): JsonResponse
    {
        $user->delete();
        return response()->json(['message' => 'Utilisateur supprimé.']);
    }
    public function toggleOffre(Offre $offre): JsonResponse
    {
        $offre->actif = ! $offre->actif;
        $offre->save();
        $etat = $offre->actif ? 'activée' : 'désactivée';
        return response()->json(['message' => "Offre {$etat}.", 'offre' => $offre]);
    }
}
