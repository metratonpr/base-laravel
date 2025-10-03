<?php

namespace Database\Factories;

use App\Models\Municipality;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'municipality_id' => Municipality::factory(),
            'razao_social' => $this->faker->company(),
            'nome_fantasia' => $this->faker->companySuffix(),
            'cnpj' => (string) $this->faker->unique()->numerify('##############'),
            'ie' => (string) $this->faker->numerify('###########'),
            'im' => $this->faker->optional()->numerify('########'),
            'crt' => $this->faker->randomElement(['1', '2', '3']),
            'logradouro' => $this->faker->streetName(),
            'numero' => (string) $this->faker->buildingNumber(),
            'complemento' => $this->faker->optional()->secondaryAddress(),
            'bairro' => $this->faker->streetSuffix(),
            'cep' => (string) $this->faker->numerify('########'),
            'phone' => (string) $this->faker->numerify('###########'),
            'email' => $this->faker->companyEmail(),
        ];
    }
}
