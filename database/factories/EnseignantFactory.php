<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enseignant>
 */
class EnseignantFactory extends Factory
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
            'cin' => $this->faker->randomNumber(5, true),
            'nom' => $this->faker->lastName(),
            'prenom' => $this->faker->firstName($gender),
            'sexe' => $sexe,
            'titre' => $this->faker->jobTitle(),
            'salaire' => $this->faker->randomFloat(0, 1500, 2000),
            'email' => $this->faker->unique()->safeEmail(),
            'tel' => $this->faker->phoneNumber(),
            'adresse' => $this->faker->address(),
            'bio' => $this->faker->paragraph($nbSentences = 4, $variableNbSentences = true),
        ];
    }
}
