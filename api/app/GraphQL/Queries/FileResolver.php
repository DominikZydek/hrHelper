<?php

namespace App\GraphQL\Queries;

use App\Models\MediaCollection;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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

    public function getThumbnail($media)
    {
        return $media->getUrl('preview');
    }
    public function getMediaCollection($media)
    {
        return MediaCollection::where('name', $media->collection_name)->first();
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

                if (isset($args['collection'])) {
                    $collectionPrefix = $args['collection'];
                    $userFiles = $userFiles->filter(function ($file) use ($collectionPrefix) {
                        return strpos($file->collection_name, $collectionPrefix) === 0;
                    });
                }

                $allFiles = $allFiles->merge($userFiles);
            }

            return $allFiles;

        } catch (\Exception $e) {
            throw new \Exception('Could not get files: ' . $e->getMessage());
        }
    }
}
