<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApprovalProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $processes = [
            ['id' => 1], // CEO - sam zatwierdza
            ['id' => 2], // CTO - zatwierdza CEO
            ['id' => 3], // Developer - zatwierdza CTO
            ['id' => 4], // HR Spec - zatwierdza HR Director i CEO
            ['id' => 5], // Frontend Dev - zatwierdza CTO
            ['id' => 6], // HR Director - zatwierdza CEO
            ['id' => 7], // UX Designer - zatwierdza CTO
            ['id' => 8], // Backend Dev - zatwierdza CTO
            ['id' => 9], // Project Manager - zatwierdza CEO
            ['id' => 10], // QA - zatwierdza CTO
            ['id' => 11], // DevOps - zatwierdza CTO
            ['id' => 12], // Marketing - zatwierdza CEO
            ['id' => 13], // Sales Manager - zatwierdza CEO
            ['id' => 14], // UI Designer - zatwierdza CTO
            ['id' => 15], // Senior Backend - zatwierdza CTO
            ['id' => 16], // Content Writer - zatwierdza CEO
            ['id' => 17], // System Admin - zatwierdza CTO
            ['id' => 18], // Office Manager - zatwierdza HR Director i CEO
            ['id' => 19], // iOS Dev - zatwierdza CTO
            ['id' => 20], // Recruitment Spec - zatwierdza HR Director i CEO
        ];
        DB::table('approval_processes')->insert($processes);
    }
}
