<?php

namespace App\GraphQL\Mutations;

use App\Models\ApprovalProcess;
use Illuminate\Support\Facades\DB;

class ApprovalProcessMutator
{
    public function updateApprovalProcess($root, array $args) {
        try {
            DB::beginTransaction();

            $approvalProcess = ApprovalProcess::findOrFail($args['id']);

            $approvalProcess->steps()->delete();
            $approvalProcess->steps()->createMany($args['steps']);

            DB::commit();

            return $approvalProcess->load('steps.approver');


        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to update approval process: ' . $e->getMessage());
        }
    }
}
