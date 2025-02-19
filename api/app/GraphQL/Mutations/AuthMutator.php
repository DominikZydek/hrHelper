<?php

namespace App\GraphQL\Mutations;

use App\Models\Organization;
use App\Models\User;
use GraphQL\Error\Error;
use Illuminate\Support\Facades\Auth;

class AuthMutator
{
    public function login($root, array $args)
    {
        // find organization
        $organization = Organization::where('alias', $args['organization_alias'])->first();
        if (!$organization) {
            throw new Error('Organization not found');
        }

        // find user
        $user = User::where('email', $args['email'])
            ->where('organization_id', $organization->id)
            ->first();
        if (!$user) {
            throw new Error('User not found in this organization');
        }

        // attempt to login
        $credentials = [
            'email' => $args['email'],
            'password' => $args['password'],
            'organization_id' => $organization->id
        ];

        if (!Auth::attempt($credentials)) {
            throw new Error('Invalid credentials');
        }

        // get authenticated user
        $user = Auth::user();

        return $user;
    }
}
