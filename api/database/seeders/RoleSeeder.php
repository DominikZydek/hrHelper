<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'Pełny dostęp do systemu',
                'organization_id' => 1,
            ],
            [
                'name' => 'hr',
                'display_name' => 'HR',
                'description' => 'Kadry i płace',
                'organization_id' => 1,
            ],
            [
                'name' => 'supervisor',
                'display_name' => 'Przełożony',
                'description' => 'Menedżer zespołu',
                'organization_id' => 1,
            ],
            [
                'name' => 'employee',
                'display_name' => 'Pracownik',
                'description' => 'Podstawowy pracownik',
                'organization_id' => 1,
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
