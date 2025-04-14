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
            ['name' => 'Tech', 'icon_name' => 'Laptop', 'organization_id' => 1],
            ['name' => 'HR', 'icon_name' => 'AccountGroup', 'organization_id' => 1],
            ['name' => 'Recruitment', 'icon_name' => 'AccountSearch', 'organization_id' => 1],
            ['name' => 'Management', 'icon_name' => 'ChartGantt', 'organization_id' => 1],
            ['name' => 'Frontend', 'icon_name' => 'MonitorDashboard', 'organization_id' => 1],
            ['name' => 'Backend', 'icon_name' => 'Database', 'organization_id' => 1],
            ['name' => 'Design', 'icon_name' => 'Palette', 'organization_id' => 1],
            ['name' => 'QA', 'icon_name' => 'TestTube', 'organization_id' => 1],
            ['name' => 'DevOps', 'icon_name' => 'CogSync', 'organization_id' => 1],
            ['name' => 'Marketing', 'icon_name' => 'Bullhorn', 'organization_id' => 1],
            ['name' => 'Sales', 'icon_name' => 'CurrencyUsd', 'organization_id' => 1],
            ['name' => 'Content', 'icon_name' => 'FileDocumentEdit', 'organization_id' => 1],
            ['name' => 'Infrastructure', 'icon_name' => 'Server', 'organization_id' => 1],
            ['name' => 'Administration', 'icon_name' => 'ShieldAccount', 'organization_id' => 1],
            ['name' => 'Mobile', 'icon_name' => 'Cellphone', 'organization_id' => 1],
            ['name' => 'Security', 'icon_name' => 'Security', 'organization_id' => 1],
            ['name' => 'Board', 'icon_name' => 'Briefcase', 'organization_id' => 1],
        ];
        DB::table('groups')->insert($groups);
    }
}
