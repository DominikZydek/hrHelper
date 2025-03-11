<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Użytkownicy
            ['name' => 'view_users', 'display_name' => 'Przeglądanie użytkowników'],
            ['name' => 'create_users', 'display_name' => 'Tworzenie użytkowników'],
            ['name' => 'edit_users', 'display_name' => 'Edycja użytkowników'],
            ['name' => 'edit_own_profile', 'display_name' => 'Edycja własnego profilu'],
            ['name' => 'change_user_roles', 'display_name' => 'Zmiana ról użytkowników'],
            ['name' => 'delete_users', 'display_name' => 'Usuwanie użytkowników'],

            // Wnioski urlopowe
            ['name' => 'create_leave_requests', 'display_name' => 'Tworzenie wniosków urlopowych'],
            ['name' => 'view_own_leave_requests', 'display_name' => 'Przeglądanie własnych wniosków'],
            ['name' => 'view_all_leave_requests', 'display_name' => 'Przeglądanie wszystkich wniosków'],
            ['name' => 'approve_leave_requests', 'display_name' => 'Zatwierdzanie wniosków urlopowych'],
            ['name' => 'cancel_own_leave_requests', 'display_name' => 'Anulowanie własnych wniosków'],
            ['name' => 'cancel_any_leave_requests', 'display_name' => 'Anulowanie dowolnych wniosków'],

            // Grupy
            ['name' => 'manage_groups', 'display_name' => 'Zarządzanie grupami'],

            // Procesy zatwierdzania
            ['name' => 'manage_approval_processes', 'display_name' => 'Zarządzanie procesami zatwierdzania'],

            // Święta firmowe
            ['name' => 'manage_company_holidays', 'display_name' => 'Zarządzanie świętami firmowymi'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
