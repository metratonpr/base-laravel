<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            ['name' => 'Diretoria', 'description' => 'Grupo respons?vel pelas decis?es estrat?gicas.'],
            ['name' => 'Financeiro', 'description' => 'Respons?vel pelo controle financeiro e fiscal.'],
            ['name' => 'Opera??es', 'description' => 'Coordena as opera??es do dia a dia da empresa.'],
            ['name' => 'Recursos Humanos', 'description' => 'Cuida da gest?o de pessoas e cultura.'],
            ['name' => 'Tecnologia', 'description' => 'Suporte ? infraestrutura e desenvolvimento de sistemas.'],
        ];

        foreach ($groups as $data) {
            Group::updateOrCreate(
                ['slug' => Str::slug($data['name'])],
                [
                    'name' => $data['name'],
                    'description' => $data['description'],
                ]
            );
        }
    }
}
