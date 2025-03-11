<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        // Przypisanie ról na podstawie konkretnych użytkowników lub ich cech
        // To podejście nie zależy od pola 'role', które ma zostać usunięte

        // 1. Określeni administratorzy po emailach
        $adminEmails = [
            'm.jankowski@company.com',
            'a.siwy@company.com'
        ];

        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $adminUsers = User::whereIn('email', $adminEmails)->get();
            foreach ($adminUsers as $user) {
                $user->roles()->syncWithoutDetaching([$adminRole->id]);
            }
        }

        // 2. HR po emailach lub innych kryteriach
        $hrEmails = [
            'a.nowak@company.com',
            'm.wisniewska@company.com'
        ];

        $hrRole = Role::where('name', 'hr')->first();
        if ($hrRole) {
            $hrUsers = User::whereIn('email', $hrEmails)->get();
            foreach ($hrUsers as $user) {
                $user->roles()->syncWithoutDetaching([$hrRole->id]);
            }
        }

        // 3. Supervisorzy po job_title zawierającym 'Manager' lub 'Director'
        $supervisorRole = Role::where('name', 'supervisor')->first();
        if ($supervisorRole) {
            $supervisorUsers = User::where('job_title', 'like', '%Manager%')
                ->orWhere('job_title', 'like', '%Director%')
                ->get();

            foreach ($supervisorUsers as $user) {
                $user->roles()->syncWithoutDetaching([$supervisorRole->id]);
            }
        }

        // 4. Wszyscy pozostali użytkownicy dostają rolę employee
        $employeeRole = Role::where('name', 'employee')->first();
        if ($employeeRole) {
            // Znajdź użytkowników bez przypisanej roli
            $usersWithoutRoles = User::whereDoesntHave('roles')->get();

            foreach ($usersWithoutRoles as $user) {
                $user->roles()->syncWithoutDetaching([$employeeRole->id]);
            }
        }
    }
}
