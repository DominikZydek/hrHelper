<?php

namespace App\GraphQL\Mutations;

use App\Models\Address;
use App\Models\User;
use GraphQL\Error\Error;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
                'supervisor_id' => $args['supervisor'],
                'type_of_employment' => $args['type_of_employment'],
                'paid_time_off_days' => $args['paid_time_off_days'],
                'working_time' => $args['working_time'],
                'employed_from' => $args['employed_from'],
                'employed_to' => $args['employed_to'],
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

            if (isset($args['roles'])) {
                $user->roles()->sync($args['roles']);
            }

            DB::commit();

            $user->refresh();

            return $user;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to update user: ' . $e->getMessage());
        }
    }
}
