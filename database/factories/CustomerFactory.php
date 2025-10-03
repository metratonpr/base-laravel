<?php

namespace Database\Factories;

use App\Models\Municipality;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $documentType = $this->faker->randomElement(['CPF', 'CNPJ']);

        return [
            'municipality_id' => Municipality::factory(),
            'nome' => $this->faker->name(),
            'razao_social' => $documentType === 'CNPJ' ? $this->faker->company() : null,
            'document_type' => $documentType,
            'document' => $documentType === 'CPF'
                ? (string) $this->faker->unique()->numerify('###########')
                : (string) $this->faker->unique()->numerify('##############'),
            'ie' => $documentType === 'CNPJ' ? (string) $this->faker->numerify('###########') : null,
            'is_ie_isento' => false,
            'logradouro' => $this->faker->streetName(),
            'numero' => (string) $this->faker->buildingNumber(),
            'complemento' => $this->faker->optional()->secondaryAddress(),
            'bairro' => $this->faker->streetSuffix(),
            'cep' => (string) $this->faker->numerify('########'),
            'phone' => (string) $this->faker->numerify('###########'),
            'email' => $this->faker->safeEmail(),
        ];
    }
}
