<?php

namespace App\GraphQL\Mutations;

use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class GroupMutator
{
    public function createGroup($root, array $args)
    {
        $currentUser = Auth::user();

        try {
            DB::beginTransaction();

            $group = Group::create([
                'name' => $args['name'],
                'icon_name' => $args['icon_name'],
                'organization_id' => $currentUser->organization_id
            ]);

            if (isset($args['selected_users'])) {
                $group->users()->sync($args['selected_users']);
            }

            DB::commit();
            return $group;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to create group: ' . $e->getMessage());
        }
    }

    public function editGroup($root, array $args)
    {
        $currentUser = Auth::user();

        try {
            DB::beginTransaction();

            $group = Group::findOrFail($args['group']);

            $group->update([
                'name' => $args['name'],
                'icon_name' => $args['icon_name'],
            ]);

            if (isset($args['selected_users'])) {
                $group->users()->sync($args['selected_users']);
            }

            DB::commit();
            return $group;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to update group: ' . $e->getMessage());
        }
    }

    public function removeGroup($root, array $args)
    {
        $currentUser = Auth::user();

        try {
            DB::beginTransaction();

            $group = Group::findOrFail($args['group']);

            $group->users()->detach();
            $group->delete();

            DB::commit();
            return $group;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to update group: ' . $e->getMessage());
        }
    }
}
