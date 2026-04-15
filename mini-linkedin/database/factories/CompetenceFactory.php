<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class CompetenceFactory extends Factory
{
    public function definition(): array
    {
        $competences = [
            ['nom' => 'PHP', 'categorie' => 'Backend'],
            ['nom' => 'Laravel', 'categorie' => 'Backend'],
            ['nom' => 'JavaScript', 'categorie' => 'Frontend'],
            ['nom' => 'React', 'categorie' => 'Frontend'],
            ['nom' => 'MySQL', 'categorie' => 'Base de données'],
            ['nom' => 'Python', 'categorie' => 'Backend'],
            ['nom' => 'Docker', 'categorie' => 'DevOps'],
            ['nom' => 'Git', 'categorie' => 'Outils'],
        ];
        $item = fake()->randomElement($competences);
        return [
            'nom' => $item['nom'],
            'categorie' => $item['categorie'],
        ];
    }
}
