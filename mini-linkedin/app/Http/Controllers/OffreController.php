<?php
namespace App\Http\Controllers;
use App\Models\Offre;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class OffreController extends Controller
{
    private function user()
    {
        return Auth::guard('api')->user();
    }
    public function index(Request $request): JsonResponse
    {
        $query = Offre::where('actif', true)
            ->orderBy('created_at', 'desc');
        if ($request->has('localisation')) {
            $query->where('localisation', 'like', '%' . $request->localisation . '%');
        }
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }
        $offres = $query->paginate(10);
        return response()->json($offres);
    }
    public function show(Offre $offre): JsonResponse
    {
        return response()->json($offre->load('recruteur'));
    }
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'localisation' => 'nullable|string',
            'type' => 'required|in:CDI,CDD,stage',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $offre = $this->user()->offres()->create($request->only('titre', 'description', 'localisation',
            'type'));
        return response()->json(['message' => 'Offre créée.', 'offre' => $offre], 201);
    }
    public function update(Request $request, Offre $offre): JsonResponse
    {
        if ($offre->user_id !== $this->user()->id) {
            return response()->json(['error' => 'Accès interdit.'], 403);
        }
        $offre->update($request->only('titre', 'description', 'localisation', 'type', 'actif'));
        return response()->json(['message' => 'Offre mise à jour.', 'offre' => $offre]);
    }
    public function destroy(Offre $offre): JsonResponse
    {
        if ($offre->user_id !== $this->user()->id) {
            return response()->json(['error' => 'Accès interdit.'], 403);
        }
        $offre->delete();
        return response()->json(['message' => 'Offre supprimée.']);
    }
}
