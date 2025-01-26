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
            ['name' => 'Tech', 'icon_name' => 'Laptop'],
            ['name' => 'HR', 'icon_name' => 'AccountGroup'],
            ['name' => 'Recruitment', 'icon_name' => 'AccountSearch'],
            ['name' => 'Management', 'icon_name' => 'ChartGantt'],
            ['name' => 'Frontend', 'icon_name' => 'MonitorDashboard'],
            ['name' => 'Backend', 'icon_name' => 'Database'],
            ['name' => 'Design', 'icon_name' => 'Palette'],
            ['name' => 'QA', 'icon_name' => 'TestTube'],
            ['name' => 'DevOps', 'icon_name' => 'CogSync'],
            ['name' => 'Marketing', 'icon_name' => 'Bullhorn'],
            ['name' => 'Sales', 'icon_name' => 'CurrencyUsd'],
            ['name' => 'Content', 'icon_name' => 'FileDocumentEdit'],
            ['name' => 'Infrastructure', 'icon_name' => 'Server'],
            ['name' => 'Administration', 'icon_name' => 'ShieldAccount'],
            ['name' => 'Mobile', 'icon_name' => 'Cellphone'],
            ['name' => 'Security', 'icon_name' => 'Security'],
            ['name' => 'Board', 'icon_name' => 'Briefcase']
        ];
        DB::table('groups')->insert($groups);
    }
}
