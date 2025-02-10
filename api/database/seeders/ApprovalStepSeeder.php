<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApprovalStepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $steps = [
            ['approval_process_id' => 1, 'order' => 1, 'approver_id' => 1], // CEO self
            ['approval_process_id' => 2, 'order' => 1, 'approver_id' => 1], // CTO -> CEO
            ['approval_process_id' => 3, 'order' => 1, 'approver_id' => 2], // Dev -> CTO
            ['approval_process_id' => 4, 'order' => 1, 'approver_id' => 6], // HR Spec -> HR Dir
            ['approval_process_id' => 4, 'order' => 2, 'approver_id' => 1], // HR Spec -> CEO
            ['approval_process_id' => 5, 'order' => 1, 'approver_id' => 2], // Frontend -> CTO
            ['approval_process_id' => 6, 'order' => 1, 'approver_id' => 1], // HR Dir -> CEO
            ['approval_process_id' => 7, 'order' => 1, 'approver_id' => 2], // UX -> CTO
            ['approval_process_id' => 8, 'order' => 1, 'approver_id' => 2], // Backend -> CTO
            ['approval_process_id' => 9, 'order' => 1, 'approver_id' => 1], // PM -> CEO
            ['approval_process_id' => 10, 'order' => 1, 'approver_id' => 2], // QA -> CTO
            ['approval_process_id' => 11, 'order' => 1, 'approver_id' => 2], // DevOps -> CTO
            ['approval_process_id' => 12, 'order' => 1, 'approver_id' => 1], // Marketing -> CEO
            ['approval_process_id' => 13, 'order' => 1, 'approver_id' => 1], // Sales -> CEO
            ['approval_process_id' => 14, 'order' => 1, 'approver_id' => 2], // UI -> CTO
            ['approval_process_id' => 15, 'order' => 1, 'approver_id' => 2], // Sr Backend -> CTO
            ['approval_process_id' => 16, 'order' => 1, 'approver_id' => 1], // Content -> CEO
            ['approval_process_id' => 17, 'order' => 1, 'approver_id' => 2], // SysAdmin -> CTO
            ['approval_process_id' => 18, 'order' => 1, 'approver_id' => 6], // Office -> HR Dir
            ['approval_process_id' => 18, 'order' => 2, 'approver_id' => 1], // Office -> CEO
            ['approval_process_id' => 19, 'order' => 1, 'approver_id' => 2], // iOS -> CTO
            ['approval_process_id' => 20, 'order' => 1, 'approver_id' => 6], // Recruit -> HR Dir
            ['approval_process_id' => 20, 'order' => 2, 'approver_id' => 1], // Recruit -> CEO
        ];
        DB::table('approval_steps')->insert($steps);
    }
}
