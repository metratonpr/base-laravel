<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'group.view', 'group.create', 'group.update', 'group.delete',
            'state.view', 'state.create', 'state.update', 'state.delete',
            'municipality.view', 'municipality.create', 'municipality.update', 'municipality.delete',
            'company.view', 'company.create', 'company.update', 'company.delete',
            'customer.view', 'customer.create', 'customer.update', 'customer.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        $roles = [
            'admin' => $permissions,
            'gestor' => [
                'group.view', 'group.create', 'group.update',
                'state.view',
                'municipality.view',
                'company.view', 'company.create', 'company.update',
                'customer.view', 'customer.create', 'customer.update',
            ],
            'operador' => [
                'group.view',
                'state.view',
                'municipality.view',
                'company.view',
                'customer.view',
            ],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::findOrCreate($roleName);
            $role->syncPermissions($rolePermissions);
        }
    }
}
