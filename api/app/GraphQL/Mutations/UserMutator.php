<?php

namespace App\GraphQL\Mutations;

use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserMutator
{
    public function updateUser($root, array $args)
    {
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

            DB::commit();

            $user->refresh();

            return $user;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to update user: ' . $e->getMessage());
        }
    }
}
