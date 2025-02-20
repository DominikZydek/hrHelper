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

        Log::info('Credentials:', $credentials);
        $success = Auth::attempt($credentials);
        Log::info('Auth attempt result:', ['success' => $success]);
        Log::info('Auth check:', ['logged_in' => Auth::check()]);

        Log::info('Session ID after login:', ['id' => session()->getId()]);
        Log::info('Session data:', session()->all());

        return $user;
    }
}
