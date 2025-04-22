<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
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
            MessageCategorySeeder::class, // Kategorie wiadomości nie zależą od innych tabel

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

            // 5. System wiadomości (zależny od użytkowników)
            MessageSeeder::class,               // Zależne od users i message_categories
            MessageRecipientSeeder::class,      // Zależne od messages i users
            MessageTemplateSeeder::class,       // Zależne od categories

            MediaCollectionSeeder::class,
        ]);
    }
}
