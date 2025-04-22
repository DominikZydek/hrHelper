<?php

namespace App\GraphQL\Mutations;

use App\Models\MediaCollection;
use App\Models\User;
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
                ->toMediaCollection($collection->name);

            return [
                'id' => $media->id,
                'file' => $media->file_name
            ];
        } catch (\Exception $e) {
            throw new \Exception('Could not upload file: ' . $e->getMessage());
        }
    }
}
