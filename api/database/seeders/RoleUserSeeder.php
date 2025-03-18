<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        // Pobranie ról z bazy danych
        $employeeRole = Role::where('name', 'employee')->first();
        $adminRole = Role::where('name', 'admin')->first();
        $hrRole = Role::where('name', 'hr')->first();
        $supervisorRole = Role::where('name', 'supervisor')->first();

        // Najpierw przypisujemy wszystkim użytkownikom rolę "employee", jeśli jeszcze jej nie mają
        if ($employeeRole) {
            $allUsers = User::all();
            foreach ($allUsers as $user) {
                $user->roles()->syncWithoutDetaching([$employeeRole->id]);
            }
        }

        // Administratorzy na podstawie emaili
        $adminEmails = ['m.jankowski@company.com', 'a.siwy@company.com'];
        if ($adminRole) {
            User::whereIn('email', $adminEmails)->each(function ($user) use ($adminRole) {
                $user->roles()->syncWithoutDetaching([$adminRole->id]);
            });
        }

        // HR na podstawie emaili
        $hrEmails = ['a.nowak@company.com', 'm.wisniewska@company.com'];
        if ($hrRole) {
            User::whereIn('email', $hrEmails)->each(function ($user) use ($hrRole) {
                $user->roles()->syncWithoutDetaching([$hrRole->id]);
            });
        }

        // Supervisorzy na podstawie job_title
        if ($supervisorRole) {
            User::where('job_title', 'like', '%Manager%')
                ->orWhere('job_title', 'like', '%Director%')
                ->each(function ($user) use ($supervisorRole) {
                    $user->roles()->syncWithoutDetaching([$supervisorRole->id]);
                });
        }
    }
}
