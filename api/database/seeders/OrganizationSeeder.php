<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = [
            [
                'alias' => 'neurotech',
                'name' => 'Neurotech Solutions',
            ],
            [
                'alias' => 'ecosphere',
                'name' => 'Ecosphere Industries',
            ]
        ];

        DB::table('organizations')->insert($organizations);
    }
}
