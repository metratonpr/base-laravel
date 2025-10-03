<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\State>
 */
class StateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->state();

        return [
            'name' => $name,
            'abbreviation' => strtoupper(Str::random(2)),
            'ibge_code' => (string) $this->faker->unique()->numberBetween(11, 99),
        ];
    }
}
