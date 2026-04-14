<?php
namespace Database\Seeders;
use App\Models\Candidature;
use App\Models\Competence;
use App\Models\Offre;
use App\Models\Profil;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'Admin Un',
            'email' => 'admin1@test.com',
            'password' => Hash::make('password'),
        ]);
        User::factory()->admin()->create([
            'name' => 'Admin Deux',
            'email' => 'admin2@test.com',
            'password' => Hash::make('password'),
        ]);
        $niveaux = ['débutant', 'intermédiaire', 'expert'];
        $competences = collect([
            ['nom' => 'PHP', 'categorie' => 'Backend'],
            ['nom' => 'Laravel', 'categorie' => 'Backend'],
            ['nom' => 'JavaScript', 'categorie' => 'Frontend'],
            ['nom' => 'React', 'categorie' => 'Frontend'],
            ['nom' => 'MySQL', 'categorie' => 'Base de données'],
            ['nom' => 'Python', 'categorie' => 'Backend'],
            ['nom' => 'Docker', 'categorie' => 'DevOps'],
            ['nom' => 'Git', 'categorie' => 'Outils'],
        ])->map(fn($c) => Competence::create($c));
        User::factory()->recruteur()->count(5)->create()->each(function ($recruteur) {
            $nbOffres = rand(2, 3);
            Offre::factory()->count($nbOffres)->create(['user_id' => $recruteur->id]);
        });
        User::factory()->candidat()->count(10)->create()->each(function ($candidat) use
        ($competences, $niveaux) {
            $profil = Profil::factory()->create(['user_id' => $candidat->id]);
            $competences->random(rand(2, 4))->each(function ($competence) use ($profil,
                $niveaux) {
                $profil->competences()->attach($competence->id, [
                    'niveau' => $niveaux[array_rand($niveaux)],
                ]);
            });
        });
    }
}
