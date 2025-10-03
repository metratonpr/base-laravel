<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Municipality;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $saoPaulo = Municipality::query()->where('ibge_code', '3550308')->value('id');
        $rioDeJaneiro = Municipality::query()->where('ibge_code', '3304557')->value('id');

        if ($saoPaulo) {
            Customer::updateOrCreate(
                ['document' => '98765432100'],
                [
                    'municipality_id' => $saoPaulo,
                    'nome' => 'Jo?o da Silva',
                    'razao_social' => null,
                    'document_type' => 'CPF',
                    'ie' => null,
                    'is_ie_isento' => true,
                    'logradouro' => 'Avenida Paulista',
                    'numero' => '1500',
                    'complemento' => 'Apto 101',
                    'bairro' => 'Bela Vista',
                    'cep' => '01310940',
                    'phone' => '11988887777',
                    'email' => 'joao.silva@example.com',
                ]
            );
        }

        if ($rioDeJaneiro) {
            Customer::updateOrCreate(
                ['document' => '11222333000181'],
                [
                    'municipality_id' => $rioDeJaneiro,
                    'nome' => 'Mercado Carioca',
                    'razao_social' => 'Mercado Carioca Com?rcio de Alimentos LTDA',
                    'document_type' => 'CNPJ',
                    'ie' => '852963741',
                    'is_ie_isento' => false,
                    'logradouro' => 'Rua Volunt?rios da P?tria',
                    'numero' => '445',
                    'complemento' => 'Loja 2',
                    'bairro' => 'Botafogo',
                    'cep' => '22270000',
                    'phone' => '2122223333',
                    'email' => 'contato@mercadocarioca.com.br',
                ]
            );
        }
    }
}
