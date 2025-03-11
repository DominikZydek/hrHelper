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
            ],
            [
                'name' => 'hr',
                'display_name' => 'HR',
                'description' => 'Kadry i płace',
            ],
            [
                'name' => 'supervisor',
                'display_name' => 'Przełożony',
                'description' => 'Menedżer zespołu',
            ],
            [
                'name' => 'employee',
                'display_name' => 'Pracownik',
                'description' => 'Podstawowy pracownik',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
