<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Type\Integer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ine' => Str::random(10),
            'nom' => $this->faker->lastName,
            'prenom' => $this->faker->firstName,
            'email' => $this->faker->safeEmail,
            'adresse' => $this->faker->address,
            'code_postal' => rand(10000, 99999),
            'ville' => $this->faker->city,
            'is_in_residence' => $this->faker->boolean,
            'residence' => $this->faker->boolean ? $this->faker->word : null,
            'statut' => $this->faker->randomElement(['A traiter', 'En cours', 'Traité']),
            'is_sub_to_newsletter' => $this->faker->boolean,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
