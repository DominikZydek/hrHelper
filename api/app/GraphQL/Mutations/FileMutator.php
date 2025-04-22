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
}
