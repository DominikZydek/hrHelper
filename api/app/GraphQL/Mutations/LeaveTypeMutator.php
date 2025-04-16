<?php

namespace App\GraphQL\Mutations;

use App\Models\LeaveType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeaveTypeMutator
{
    public function createLeaveType($root, array $args)
    {
        $currentUser = Auth::user();

        try {
            DB::beginTransaction();

            $leaveType = LeaveType::create([
                'name' => $args['name'],
                'limit_per_year' => $args['limit_per_year'],
                'requires_replacement' => $args['requires_replacement'],
                'min_notice_days' => $args['min_notice_days'],
                'can_be_cancelled' => $args['can_be_cancelled'],
                'organization_id' => $currentUser->organization_id,
            ]);

            DB::commit();
            return $leaveType;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to create leave type: ' . $e->getMessage());
        }
    }

    public function editLeaveType($root, array $args)
    {
        $currentUser = Auth::user();

        try {
            DB::beginTransaction();

            $leaveType = LeaveType::findOrFail($args['leave_type']);

            $leaveType->update([
                'name' => $args['name'],
                'limit_per_year' => $args['limit_per_year'],
                'requires_replacement' => $args['requires_replacement'],
                'min_notice_days' => $args['min_notice_days'],
                'can_be_cancelled' => $args['can_be_cancelled'],
            ]);

            DB::commit();
            return $leaveType;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to update leave type: ' . $e->getMessage());
        }
    }

    public function removeLeaveType($root, array $args)
    {
        $currentUser = Auth::user();

        try {
            DB::beginTransaction();

            $leaveType = LeaveType::findOrFail($args['leave_type']);

            // TODO: change this to softDelete provided by laravel
            $leaveType->update([
                'is_deleted' => true
            ]);

            DB::commit();
            return $leaveType;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to remove leave type: ' . $e->getMessage());
        }
    }
}
