<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Municipality;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $curitiba = Municipality::query()->where('ibge_code', '4106902')->value('id');

        if (! $curitiba) {
            return;
        }

        Company::updateOrCreate(
            ['cnpj' => '12345678000100'],
            [
                'municipality_id' => $curitiba,
                'razao_social' => 'Empresa Exemplo LTDA',
                'nome_fantasia' => 'Empresa Exemplo',
                'ie' => '1234567890',
                'im' => '10500',
                'crt' => '3',
                'logradouro' => 'Rua XV de Novembro',
                'numero' => '123',
                'complemento' => 'Conjunto 501',
                'bairro' => 'Centro',
                'cep' => '80010000',
                'phone' => '41999999999',
                'email' => 'contato@empresaexemplo.com.br',
            ]
        );
    }
}
