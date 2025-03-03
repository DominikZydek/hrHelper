<?php

namespace App\GraphQL\Queries;

use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Auth;

class LeaveRequestResolver
{
    public function leaveRequestsAwaitingApproval($root, array $args)
    {
        $currentUser = Auth::user();

        return LeaveRequest::where('status', 'IN_PROGRESS')
            ->whereHas('approval_process', function ($query) use ($currentUser) {
                $query->whereHas('steps', function ($query) use ($currentUser) {
                    $query->where('approver_id', $currentUser->id)
                        ->whereRaw('leave_requests.current_approval_step = approval_steps.order');
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
}
