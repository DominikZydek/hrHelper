<?php

namespace App\GraphQL\Mutations;

use App\Mail\ActivationMail;
use App\Models\Address;
use App\Models\User;
use GraphQL\Error\Error;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserMutator
{
    public function updateUser($root, array $args)
    {
        $currentUser = Auth::user();

        if ($currentUser->id != $args['id'] && !$currentUser->hasPermission('edit_users')) {
            throw new Error('You do not have permission to edit users.');
        } else if (!$currentUser->hasPermission('edit_own_profile')) {
            throw new Error('You do not have permission to edit your own profile.');
        }

        // TODO: check permissions for managing groups, roles


        try {
            DB::beginTransaction();

            $user = User::findOrFail($args['id']);
            $address = Address::findOrFail($user->address_id);

            $user->fill([
                'first_name' => $args['first_name'],
                'last_name' => $args['last_name'],
                'sex' => $args['sex'],
                'email' => $args['email'],
                'birth_date' => $args['birth_date'],
                'phone_number' => $args['phone_number'],
                'job_title' => $args['job_title'],
                'supervisor_id' => $args['supervisor'] ?? null,
                'type_of_employment' => $args['type_of_employment'],
                'paid_time_off_days' => $args['paid_time_off_days'],
                'working_time' => $args['working_time'],
                'employed_from' => $args['employed_from'],
                'employed_to' => $args['employed_to'] ?? null,
                'health_check_expired_by' => $args['health_check_expired_by'],
                'health_and_safety_training_expired_by' => $args['health_and_safety_training_expired_by']
            ]);

            $address->fill([
                'street_name' => $args['street_name'],
                'street_number' => $args['street_number'],
                'postal_code' => $args['postal_code'],
                'city' => $args['city']
            ]);

            $user->save();
            $address->save();

            if (isset($args['groups'])) {
                $user->groups()->sync($args['groups']);
            }

            $roles = $args['roles'] ?? [];

            // add employee role regardless
            if (!in_array(4, $roles)) {
                $roles[] = 4;
            }

            $user->roles()->sync($roles);

            DB::commit();

            $user->refresh();

            return $user;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to update user: ' . $e->getMessage());
        }
    }

    public function createUser($root, array $args)
    {
        $currentUser = Auth::user();

        if (!$currentUser->hasPermission('create_users')) {
            throw new Error('You do not have permission to create users.');
        }

        try {
            DB::beginTransaction();

            $address = Address::create([
                'street_name' => $args['street_name'],
                'street_number' => $args['street_number'],
                'postal_code' => $args['postal_code'],
                'city' => $args['city']
            ]);

            $activation_token = Str::random(60);

            $user = User::create([
                'organization_id' => $currentUser->organization_id,
                'password' => 'INACTIVE ACCOUNT',
                'first_name' => $args['first_name'],
                'last_name' => $args['last_name'],
                'sex' => $args['sex'],
                'email' => $args['email'],
                'birth_date' => $args['birth_date'],
                'phone_number' => $args['phone_number'],
                'address_id' => $address->id,
                'job_title' => $args['job_title'],
                'supervisor_id' => $args['supervisor'] ?? null,
                'approval_process_id' => 1, // TODO: this is temporary
                'type_of_employment' => $args['type_of_employment'],
                'paid_time_off_days' => $args['paid_time_off_days'],
                'working_time' => $args['working_time'],
                'employed_from' => $args['employed_from'],
                'employed_to' => $args['employed_to'] ?? null,
                'available_pto' => $args['paid_time_off_days'] * $args['working_time'],
                'pending_pto' => 0,
                'transferred_pto' => 0, // TODO: this should be sent from the frontend
                'transferred_pto_expired_by' => '2025-09-30', // TODO: this should be calculated
                'health_check_expired_by' => $args['health_check_expired_by'],
                'health_and_safety_training_expired_by' => $args['health_and_safety_training_expired_by'],
                'activation_token' => $activation_token
            ]);

            if (isset($args['groups'])) {
                $user->groups()->sync($args['groups']);
            }

            $roles = $args['roles'] ?? [];

            // add employee role regardless
            if (!in_array(4, $roles)) {
                $roles[] = 4;
            }

            $user->roles()->sync($roles);

            DB::commit();

            // mail activation link to user
            Mail::to($user->email)->send(new ActivationMail($user));

            return $user;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to create user: ' . $e->getMessage());
        }
    }

    public function activateUserAccount($root, array $args)
    {
        $user = User::where('activation_token', $args['activation_token'])->first();

        try {
            DB::beginTransaction();

            $user->fill([
                'activation_token' => null,
                'password' => bcrypt($args['password']),
            ]);

            $user->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to activate user account: ' . $e->getMessage());
        }

        return $user;
    }
}
