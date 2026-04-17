<?php
namespace App\Listeners;
use App\Events\StatutCandidatureMis;
use Illuminate\Support\Facades\Log;
class LogStatutCandidatureMis
{
    public function handle(StatutCandidatureMis $event): void
    {
        $date = now()->format('Y-m-d H:i:s');
        $ancienStatut = $event->ancienStatut;
        $nouveauStatut = $event->nouveauStatut;
        $id = $event->candidature->id;
        $message = "[{$date}] Statut mis à jour — Candidature #{$id} — {$ancienStatut} →
{$nouveauStatut}";
        Log::channel('candidatures')->info($message);
    }
}
