<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            // 1. Najpierw tabele niezależne od innych
            OrganizationSeeder::class,
            AddressSeeder::class,
            ApprovalProcessSeeder::class,
            RoleSeeder::class,        // Role muszą istnieć przed użytkownikami
            PermissionSeeder::class,  // Uprawnienia również muszą istnieć przed użytkownikami
            GroupSeeder::class,       // Grupy też muszą być przed użytkownikami

            // 2. Użytkownicy (zależni od organizacji, adresów, procesów zatwierdzania)
            UserSeeder::class,

            // 3. Relacje między użytkownikami a innymi tabelami
            UserGroupSeeder::class,          // Zależne od users i groups
            RoleUserSeeder::class,           // Zależne od users i roles
            RolePermissionSeeder::class,     // Zależne od roles i permissions
            PermissionOverrideSeeder::class, // Zależne od users i permissions
            ApprovalStepSeeder::class,       // Zależne od users i approval_processes

            // 4. Pozostałe tabele zależne od users
            LeaveTypeSeeder::class,             // Niezależne, ale logicznie przed wnioskami
            LeaveRequestSeeder::class,          // Zależne od users i leave_types
            LeaveRequestReplacementSeeder::class, // Zależne od leave_requests i users
            ApprovalStepsHistorySeeder::class,  // Zależne od leave_requests
            CompanyHolidaySeeder::class,        // Zależne od organizations
        ]);
    }
}
