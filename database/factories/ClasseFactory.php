<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Classe>
 */
class ClasseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $annee = $this->faker->randomElement([2017, 2018, 2019, 2020, 2021]);
        return [
            'annee' => $annee.'-'.($annee + 1),
            'niveau' => $this->faker->randomElement(['1ere année', '2eme année', '3eme année', '4eme année', '5eme année', '6eme année']),
        ];
    }
}
