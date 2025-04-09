<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class NewMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function via($notifiable): array
    {
        Log::info('Notification via called');
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable): array
    {
        Log::info('toDatabase called for notification');
        return [
            'id' => $this->message->id,
            'type' => 'message',
            'title' => 'Nowa wiadomość',
            'message' => "Od: {$this->message->author->first_name} {$this->message->author->last_name}",
            'subject' => $this->message->subject,
            'url' => '/home/messages/view-messages',
            'author_id' => $this->message->author_id,
            'created_at' => $this->message->created_at,
            'priority' => $this->message->priority
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        Log::info('toBroadcast called for notification');

        return new BroadcastMessage([
            'id' => $this->message->id,
            'type' => 'App\\Notifications\\NewMessageNotification',
            'data' => [
                'id' => $this->message->id,
                'type' => 'message',
                'title' => 'Nowa wiadomość',
                'message' => "Od: {$this->message->author->first_name} {$this->message->author->last_name}",
                'url' => '/home/messages/view-messages',
                'comment' => null,
                'action_type' => null
            ],
            'read_at' => null,
            'created_at' => now()->toIso8601String()
        ]);
    }
}
