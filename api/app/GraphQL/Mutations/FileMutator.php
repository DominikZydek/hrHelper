<?php

namespace App\GraphQL\Mutations;

use App\Models\MediaCollection;
use App\Models\User;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Auth;

class FileMutator
{
    public function uploadFile($root, array $args)
    {
        $file = $args['file'];

        try {
            $user = User::findOrFail($args['user']);

            $collection = MediaCollection::findOrFail($args['collection']);

            $media = $user->addMedia($file)
                ->usingName($args['file_name'])
                ->withCustomProperties([
                    'date_from' => $args['date_from'],
                    'date_to' => $args['date_to'],
                    'date_archive' => $args['date_archive'],
                ])
                ->toMediaCollection($collection->name);

            return $media;

        } catch (\Exception $e) {
            throw new \Exception('Could not upload file: ' . $e->getMessage());
        }
    }

    public function updateFile($root, array $args)
    {
        try {
            $media = Media::findOrFail($args['id']);
            $user = User::findOrFail($args['user']);
            $collection = MediaCollection::findOrFail($args['collection']);

            // update media properties
            $media->name = $args['file_name'];
            $media->custom_properties = [
                'date_from' => $args['date_from'],
                'date_to' => $args['date_to'],
                'date_archive' => $args['date_archive'],
            ];

            // move to different collection if needed
            if ($media->collection_name !== $collection->name) {
                $media->move($user, $collection->name);
            }

            // update model association if needed
            if ($media->model_id !== $user->id) {
                $media->model_type = get_class($user);
                $media->model_id = $user->id;
            }

            $media->save();

            return $media->fresh();

        } catch (\Exception $e) {
            throw new \Exception('Could not update file: ' . $e->getMessage());
        }
    }

    public function updateFileWithNewFile($root, array $args)
    {
        $newFile = $args['file'];

        try {
            $oldMedia = Media::findOrFail($args['id']);
            $user = User::findOrFail($args['user']);
            $collection = MediaCollection::findOrFail($args['collection']);

            // delete old file
            $oldMedia->delete();

            // upload new file with same properties
            $media = $user->addMedia($newFile)
                ->usingName($args['file_name'])
                ->withCustomProperties([
                    'date_from' => $args['date_from'],
                    'date_to' => $args['date_to'],
                    'date_archive' => $args['date_archive'],
                ])
                ->toMediaCollection($collection->name);

            return $media;

        } catch (\Exception $e) {
            throw new \Exception('Could not update file with new file: ' . $e->getMessage());
        }
    }

    public function deleteFile($root, array $args)
    {
        try {
            $media = Media::findOrFail($args['id']);

            $media->delete();

            return true;

        } catch (\Exception $e) {
            throw new \Exception('Could not delete file: ' . $e->getMessage());
        }
    }

    public function archiveFile($root, array $args)
    {
        try {
            $media = Media::findOrFail($args['id']);

            // check if archive collection exists
            $archiveCollection = MediaCollection::where('name', 'archive')->first();
            if (!$archiveCollection) {
                throw new \Exception('Archive collection not found');
            }

            // move to archive collection
            $media->move($media->model, 'archive');

            return $media->fresh();

        } catch (\Exception $e) {
            throw new \Exception('Could not archive file: ' . $e->getMessage());
        }
    }
}
