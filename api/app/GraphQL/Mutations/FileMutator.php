<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FileMutator
{
    public function uploadFile($root, array $args)
    {
        $file = $args['file'];

        try {
            $user = User::findOrFail($args['user']);

            $media = $user->addMedia($file)
                ->toMediaCollection($args['collection']);

            return [
                'id' => $media->id,
                'file' => $media->file_name
            ];
        } catch (\Exception $e) {
            throw new \Exception('Could not upload file: ' . $e->getMessage());
        }
    }
}
