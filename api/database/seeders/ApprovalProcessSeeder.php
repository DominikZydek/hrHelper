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
        // empty for now
        $processes = [];
        for ($i = 1; $i <= 20; $i++) {
            $processes[] = ['dummy' => 'dummy'];
        }
        DB::table('approval_processes')->insert($processes);
    }
}
