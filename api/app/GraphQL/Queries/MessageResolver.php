<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Facades\Auth;

class MessageResolver
{
    public function seen($root, array $args) {
        $currentUser = Auth::user();

        if (!$currentUser) {
            return false;
        }
        $message = $root;

        $recipient = $message->recipients()
            ->wherePivot('recipient_id', $currentUser->id)
            ->first();

        return $recipient ? (bool)$recipient->pivot->seen : false;
    }
}
