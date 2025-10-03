<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrador',
                'email' => 'admin@example.com',
                'password' => 'password',
                'role' => 'admin',
            ],
            [
                'name' => 'Gestor',
                'email' => 'gestor@example.com',
                'password' => 'password',
                'role' => 'gestor',
            ],
            [
                'name' => 'Operador',
                'email' => 'operador@example.com',
                'password' => 'password',
                'role' => 'operador',
            ],
        ];

        foreach ($users as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($data['password']),
                ]
            );

            $user->syncRoles([$data['role']]);
        }
    }
}
