<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Facades\Auth;

class NotificationResolver
{
    public function userNotifications($root, array $args)
    {
        $user = Auth::user();

        return $user->notifications()
            ->orderBy('created_at', 'desc')
            ->take(50)
            ->get();
    }

    public function unreadNotificationsCount($root, array $args)
    {
        $user = Auth::user();

        return $user->unreadNotifications()->count();
    }
}
