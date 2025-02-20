<?php

namespace App\GraphQL\Mutations;

use App\Models\Organization;
use App\Models\User;
use GraphQL\Error\Error;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthMutator
{
    public function login($root, array $args)
    {
        // find organization
        $organization = Organization::where('alias', $args['organization_alias'])->first();
        if (!$organization) {
            throw new Error('Podany alias nie istnieje');
        }

        // find user
        $user = User::where('email', $args['email'])
            ->where('organization_id', $organization->id)
            ->first();
        if (!$user) {
            throw new Error('Błędne dane logowania');
        }

        // attempt to login
        $credentials = [
            'email' => $args['email'],
            'password' => $args['password'],
            'organization_id' => $organization->id
        ];

        if (!Auth::attempt($credentials)) {
            throw new Error('Błędne dane logowania');
        }

        // get authenticated user
        $user = Auth::user();

        return $user;
    }
}
