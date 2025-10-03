<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            StateSeeder::class,
            MunicipalitySeeder::class,
            CompanySeeder::class,
            CustomerSeeder::class,
            RoleAndPermissionSeeder::class,
            GroupSeeder::class,
            UserSeeder::class,
        ]);

        $user = User::updateOrCreate(
            ['email' => 'julianovieira@yahoo.com.br'],
            [
                'name' => 'JULIANO ROQUE VIEIRA',
                'password' => bcrypt('password'),
            ]
        );

        $user->syncRoles(['admin']);
    }
}
