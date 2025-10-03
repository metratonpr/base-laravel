<?php

namespace Database\Factories;

use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Municipality>
 */
class MunicipalityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'state_id' => State::factory(),
            'name' => $this->faker->city(),
            'ibge_code' => (string) $this->faker->unique()->numerify('#######'),
            'siafi_code' => $this->faker->optional()->numerify('#####'),
        ];
    }
}
