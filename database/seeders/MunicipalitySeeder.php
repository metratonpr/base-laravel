<?php

namespace Database\Seeders;

use App\Models\Municipality;
use App\Models\State;
use Illuminate\Database\Seeder;

class MunicipalitySeeder extends Seeder
{
    public function run(): void
    {
        $municipalities = [
            ['name' => 'Curitiba', 'state' => 'PR', 'ibge_code' => '4106902', 'siafi_code' => '7535'],
            ['name' => 'Londrina', 'state' => 'PR', 'ibge_code' => '4113700', 'siafi_code' => '7544'],
            ['name' => 'São Paulo', 'state' => 'SP', 'ibge_code' => '3550308', 'siafi_code' => '7107'],
            ['name' => 'Campinas', 'state' => 'SP', 'ibge_code' => '3509502', 'siafi_code' => '6251'],
            ['name' => 'Rio de Janeiro', 'state' => 'RJ', 'ibge_code' => '3304557', 'siafi_code' => '6001'],
            ['name' => 'Niterói', 'state' => 'RJ', 'ibge_code' => '3303302', 'siafi_code' => '6005'],
            ['name' => 'Belo Horizonte', 'state' => 'MG', 'ibge_code' => '3106200', 'siafi_code' => '4123'],
            ['name' => 'Uberlândia', 'state' => 'MG', 'ibge_code' => '3170206', 'siafi_code' => '4753'],
            ['name' => 'Brasília', 'state' => 'DF', 'ibge_code' => '5300108', 'siafi_code' => '9701'],
            ['name' => 'Salvador', 'state' => 'BA', 'ibge_code' => '2927408', 'siafi_code' => '3849'],
            ['name' => 'Manaus', 'state' => 'AM', 'ibge_code' => '1302603', 'siafi_code' => '0255'],
        ];

        foreach ($municipalities as $municipality) {
            $stateId = State::query()
                ->where('abbreviation', $municipality['state'])
                ->value('id');

            if (! $stateId) {
                continue;
            }

            Municipality::updateOrCreate(
                ['ibge_code' => $municipality['ibge_code']],
                [
                    'state_id' => $stateId,
                    'name' => $municipality['name'],
                    'siafi_code' => $municipality['siafi_code'],
                ]
            );
        }
    }
}
