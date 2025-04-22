<?php

namespace App\GraphQL\Queries;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FileResolver
{
    public function getUrl($media)
    {
        return $media->getUrl();
    }

    public function getUser($media)
    {
        if ($media->model_type === User::class || $media->model_type === 'App\\Models\\User') {
            return User::find($media->model_id);
        }

        return null;
    }

    public function organizationFiles($root, array $args)
    {
        $currentUser = Auth::user();

        try {
            $organization = Organization::findOrFail($currentUser->organization_id);
            $users = $organization->users;
            $allFiles = collect();

            foreach ($users as $user) {
                $userFiles = $user->files;
                $allFiles = $allFiles->merge($userFiles);
            }
            return $allFiles;

        } catch (\Exception $e) {
            throw new \Exception('Could not get files: ' . $e->getMessage());
        }
    }
}
