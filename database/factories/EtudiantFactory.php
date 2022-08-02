<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Etudiant>
 */
class EtudiantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $gender = $this->faker->randomElement(['male', 'female']);
        $sexe = $gender === 'male' ? 'M' : 'F';
        return [
            'cne' => $this->faker->randomNumber(5, true),
            'nom' => $this->faker->lastName(),
            'prenom' => $this->faker->firstName($gender),
            'sexe' => $sexe,
            'date_de_naissance' => $this->faker->date(),
            'email' => $this->faker->unique()->safeEmail(),
            'tel' => $this->faker->phoneNumber(),
            'adresse' => $this->faker->address(),
            'bio' => $this->faker->paragraph($nbSentences = 4, $variableNbSentences = true),
        ];
    }
}
