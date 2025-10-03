<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    public function run(): void
    {
        $states = [
            ['name' => 'Rondônia', 'abbreviation' => 'RO', 'ibge_code' => '11'],
            ['name' => 'Acre', 'abbreviation' => 'AC', 'ibge_code' => '12'],
            ['name' => 'Amazonas', 'abbreviation' => 'AM', 'ibge_code' => '13'],
            ['name' => 'Roraima', 'abbreviation' => 'RR', 'ibge_code' => '14'],
            ['name' => 'Pará', 'abbreviation' => 'PA', 'ibge_code' => '15'],
            ['name' => 'Amapá', 'abbreviation' => 'AP', 'ibge_code' => '16'],
            ['name' => 'Tocantins', 'abbreviation' => 'TO', 'ibge_code' => '17'],
            ['name' => 'Maranhão', 'abbreviation' => 'MA', 'ibge_code' => '21'],
            ['name' => 'Piauí', 'abbreviation' => 'PI', 'ibge_code' => '22'],
            ['name' => 'Ceará', 'abbreviation' => 'CE', 'ibge_code' => '23'],
            ['name' => 'Rio Grande do Norte', 'abbreviation' => 'RN', 'ibge_code' => '24'],
            ['name' => 'Paraíba', 'abbreviation' => 'PB', 'ibge_code' => '25'],
            ['name' => 'Pernambuco', 'abbreviation' => 'PE', 'ibge_code' => '26'],
            ['name' => 'Alagoas', 'abbreviation' => 'AL', 'ibge_code' => '27'],
            ['name' => 'Sergipe', 'abbreviation' => 'SE', 'ibge_code' => '28'],
            ['name' => 'Bahia', 'abbreviation' => 'BA', 'ibge_code' => '29'],
            ['name' => 'Minas Gerais', 'abbreviation' => 'MG', 'ibge_code' => '31'],
            ['name' => 'Espírito Santo', 'abbreviation' => 'ES', 'ibge_code' => '32'],
            ['name' => 'Rio de Janeiro', 'abbreviation' => 'RJ', 'ibge_code' => '33'],
            ['name' => 'São Paulo', 'abbreviation' => 'SP', 'ibge_code' => '35'],
            ['name' => 'Paraná', 'abbreviation' => 'PR', 'ibge_code' => '41'],
            ['name' => 'Santa Catarina', 'abbreviation' => 'SC', 'ibge_code' => '42'],
            ['name' => 'Rio Grande do Sul', 'abbreviation' => 'RS', 'ibge_code' => '43'],
            ['name' => 'Mato Grosso do Sul', 'abbreviation' => 'MS', 'ibge_code' => '50'],
            ['name' => 'Mato Grosso', 'abbreviation' => 'MT', 'ibge_code' => '51'],
            ['name' => 'Goiás', 'abbreviation' => 'GO', 'ibge_code' => '52'],
            ['name' => 'Distrito Federal', 'abbreviation' => 'DF', 'ibge_code' => '53'],
        ];

        foreach ($states as $state) {
            State::updateOrCreate(
                ['abbreviation' => $state['abbreviation']],
                $state
            );
        }
    }
}
