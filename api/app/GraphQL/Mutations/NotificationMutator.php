<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use App\Notifications\NewMessageNotification;
use Carbon\Carbon;
use GraphQL\Error\Error;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class NotificationMutator
{
    public function markNotificationAsRead($root, array $args)
    {
        $user = Auth::user();

        $notification = $user->notifications()->where('id', $args['id'])->first();

        if (!$notification) {
            throw new Error('Notification not found');
        }

        $notification->markAsRead();

        return true;
    }

    public function markAllNotificationsAsRead($root, array $args)
    {
        $user = Auth::user();

        $user->unreadNotifications()->update(['read_at' => now()]);

        return true;
    }

    public function addNotification($root, array $args)
    {
        $user = User::findOrFail(4);

        $message = Message::create([
            'author_id' => 1,
            'subject' => 'subject',
            'message_category_id' => 1,
            'content' => 'www',
            'priority' => 1,
            'publication_date' => Carbon::now(),
            'date_from' => null,
            'date_to' => null,
            'require_confirmation' => false,
        ]);

        $user->notify(new NewMessageNotification($message));

        return $message;
    }
}
