<?php
namespace App\Listeners;
use App\Events\CandidatureDeposee;
use Illuminate\Support\Facades\Log;
class LogCandidatureDeposee
{
    public function handle(CandidatureDeposee $event): void
    {
        $candidature = $event->candidature;
        $candidat = $candidature->profil->user->name;
        $offre = $candidature->offre->titre;
        $date = now()->format('Y-m-d H:i:s');
        $message = "[{$date}] Candidature déposée — Candidat : {$candidat} — Offre :
{$offre}";
        Log::channel('candidatures')->info($message);
    }
}
