<?php

namespace App\GraphQL\Queries;

use App\Models\LeaveRequest;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;

class LeaveRequestResolver
{
    public function leaveRequestsWhereUserIsApprover($root, array $args)
    {
        $currentUser = Auth::user();

        return LeaveRequest::whereHas('approval_process', function ($query) use ($currentUser) {
            $query->whereHas('steps', function ($query) use ($currentUser) {
                $query->where('approver_id', $currentUser->id);
            });
        })
            ->with([
                'user',
                'leave_type',
                'approval_process.steps.approver',
                'replacement.user',
                'approval_steps_history.approver'
            ])
            ->get();
    }

    public function leaveRequests($root, array $args)
    {
        $currentUser = Auth::user();

        if ($currentUser->hasPermission('view_all_leave_requests')) {
            $organization = Organization::findOrFail($args['organization']);

            // return all leave requests in which users have specific organization_id
            return LeaveRequest::whereHas('user', function($query) use ($organization) {
                $query->where('organization_id', $organization->id);
            })->get();
        }

        return null;
    }
}
