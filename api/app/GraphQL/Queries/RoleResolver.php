<?php

namespace App\GraphQL\Queries;

use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class RoleResolver
{
    public function organizationRoles($root, array $args)
    {
        $currentUser = Auth::user();

        return Role::where('organization_id', $currentUser->organization_id)->get();
    }
}
