<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

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
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable): array
    {
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
        return new BroadcastMessage($this->toDatabase($notifiable));
    }
}
