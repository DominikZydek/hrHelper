<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            ['name' => 'Tech'],
            ['name' => 'HR'],
            ['name' => 'Recruitment'],
            ['name' => 'Management'],
            ['name' => 'Frontend'],
            ['name' => 'Backend'],
            ['name' => 'Design'],
            ['name' => 'QA'],
            ['name' => 'DevOps'],
            ['name' => 'Marketing'],
            ['name' => 'Sales'],
            ['name' => 'Content'],
            ['name' => 'Infrastructure'],
            ['name' => 'Administration'],
            ['name' => 'Mobile'],
            ['name' => 'Security'],
            ['name' => 'Board']
        ];
        DB::table('groups')->insert($groups);
    }
}
