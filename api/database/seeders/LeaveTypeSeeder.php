<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leaveTypes = [
            [
                'name' => 'Urlop wypoczynkowy',
                'limit_per_year' => 26,
                'requires_replacement' => true,
                'min_notice_days' => 14,
                'can_be_cancelled' => true
            ],
            [
                'name' => 'Urlop na żądanie',
                'limit_per_year' => 4,
                'requires_replacement' => true,
                'min_notice_days' => 0,
                'can_be_cancelled' => false
            ],
            [
                'name' => 'Urlop okolicznościowy',
                'limit_per_year' => 2,
                'requires_replacement' => false,
                'min_notice_days' => 1,
                'can_be_cancelled' => false
            ],
            [
                'name' => 'Urlop szkoleniowy',
                'limit_per_year' => 6,
                'requires_replacement' => true,
                'min_notice_days' => 7,
                'can_be_cancelled' => true
            ],
            [
                'name' => 'Urlop bezpłatny',
                'limit_per_year' => 0,
                'requires_replacement' => true,
                'min_notice_days' => 30,
                'can_be_cancelled' => true
            ],
            [
                'name' => 'Opieka nad dzieckiem',
                'limit_per_year' => 2,
                'requires_replacement' => true,
                'min_notice_days' => 1,
                'can_be_cancelled' => false
            ],
            [
                'name' => 'Urlop macierzyński',
                'limit_per_year' => 0,
                'requires_replacement' => true,
                'min_notice_days' => 30,
                'can_be_cancelled' => false
            ],
            [
                'name' => 'Urlop ojcowski',
                'limit_per_year' => 0,
                'requires_replacement' => true,
                'min_notice_days' => 30,
                'can_be_cancelled' => false
            ]
        ];

        DB::table('leave_types')->insert($leaveTypes);
    }
}
