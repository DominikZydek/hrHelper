<?php

namespace App\GraphQL\Queries;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserResolver
{
    public function users($root, array $args)
    {
        return User::with(['groups', 'supervisor', 'address', 'approval_process'])->get();
    }

    public function absentEmployees($root, array $args)
    {
        $currentUser = Auth::user();

        if ($currentUser->hasPermission('view_users')) {
            $organization = Organization::findOrFail($args['organization']);

            /*
                get all users with a specific organization_id that have APPROVED leave requests that are currently
                ongoing (date_from - now - date_to)
            */
            $absentEmployees = User::where('organization_id', $organization->id)
                ->whereHas('leave_requests', function ($query) {
                    $today = now()->format('Y-m-d');
                    $query->where('status', 'APPROVED')
                        ->where('date_from', '<=', $today)
                        ->where('date_to', '>=', $today);
                })
                ->with(['leave_requests' => function ($query) {
                    $today = now()->format('Y-m-d');
                    $query->where('status', 'APPROVED')
                        ->where('date_from', '<=', $today)
                        ->where('date_to', '>=', $today);
                }])
                ->get();

            return $absentEmployees;
        }

        return null;
    }
}
