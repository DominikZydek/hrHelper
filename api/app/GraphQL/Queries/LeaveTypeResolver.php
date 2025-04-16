<?php

namespace App\GraphQL\Queries;

use App\Models\LeaveType;
use Illuminate\Support\Facades\Auth;

class LeaveTypeResolver
{
    public function organizationLeaveTypes($root, array $args)
    {
        $currentUser = Auth::user();

        return LeaveType::where('organization_id', $currentUser->organization_id)
            ->where('is_deleted', false)
            ->get();
    }
}
