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
            AddressSeeder::class,
            ApprovalProcessSeeder::class,
            UserSeeder::class,
            GroupSeeder::class,
            UserGroupSeeder::class,
            ApprovalStepSeeder::class,
        ]);
    }
}
