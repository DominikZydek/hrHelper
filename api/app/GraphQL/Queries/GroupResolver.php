<?php

namespace App\GraphQL\Queries;

use App\Models\Group;
use Illuminate\Support\Facades\Auth;

class GroupResolver
{
    public function organizationGroups($root, array $args)
    {
        $currentUser = Auth::user();

        return Group::where('organization_id', $currentUser->organization_id)->get();
    }
}
