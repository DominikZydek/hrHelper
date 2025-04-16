<?php

namespace App\GraphQL\Mutations;

use App\Models\Group;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleMutator
{
    public function editRole($root, array $args)
    {
        $currentUser = Auth::user();

        try {
            DB::beginTransaction();

            $role = Role::findOrFail($args['role']);

            $role->permissions()->sync($args['permissions']);

            DB::commit();
            return $role;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to update role: ' . $e->getMessage());
        }
    }
}
