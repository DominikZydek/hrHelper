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
            OrganizationSeeder::class,
            AddressSeeder::class,
            ApprovalProcessSeeder::class,
            UserSeeder::class,
            GroupSeeder::class,
            UserGroupSeeder::class,
            ApprovalStepSeeder::class,
            LeaveTypeSeeder::class,
            LeaveRequestSeeder::class,
            LeaveRequestReplacementSeeder::class,
            ApprovalStepsHistorySeeder::class,
            CompanyHolidaySeeder::class,
        ]);
    }
}
