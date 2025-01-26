<?php

namespace App\GraphQL\Queries;

use App\Models\User;

class UserResolver
{
    public function users($root, array $args)
    {
        return User::with(['groups', 'supervisor', 'address', 'approval_process'])->get();
    }
}
