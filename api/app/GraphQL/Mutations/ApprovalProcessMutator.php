<?php

namespace App\GraphQL\Mutations;

use App\Models\ApprovalProcess;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use GraphQL\Error\Error;

class ApprovalProcessMutator
{
    public function updateApprovalProcess($root, array $args) {

        $user = Auth::user();
        if (!$user->hasPermission('manage_approval_process')) {
            throw new Error('You can not update approval process.');
        }

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
