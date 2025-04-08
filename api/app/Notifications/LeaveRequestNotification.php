<?php

namespace App\Notifications;

use App\Models\LeaveRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class LeaveRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $leaveRequest;
    protected $type;
    protected $comment;

    public function __construct(LeaveRequest $leaveRequest, string $type, ?string $comment = null)
    {
        $this->leaveRequest = $leaveRequest;
        $this->type = $type;
        $this->comment = $comment;
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable): array
    {
        $title = 'Wniosek urlopowy';
        $message = '';
        $url = '/home/leave-management/my-requests';

        switch ($this->type) {
            case 'new_approval':
                $title = 'Nowy wniosek do zatwierdzenia';
                $message = "Od: {$this->leaveRequest->user->first_name} {$this->leaveRequest->user->last_name}";
                $url = '/home/leave-management/approvals';
                break;
            case 'approved':
                $title = 'Wniosek zatwierdzony';
                $message = "Twój wniosek urlopowy został zatwierdzony";
                break;
            case 'rejected':
                $title = 'Wniosek odrzucony';
                $message = "Twój wniosek urlopowy został odrzucony";
                break;
            case 'next_approval':
                $title = 'Wniosek oczekuje na Twoją decyzję';
                $message = "Wniosek {$this->leaveRequest->user->first_name} {$this->leaveRequest->user->last_name} oczekuje na Twoją akceptację";
                $url = '/home/leave-management/approvals';
                break;
        }

        return [
            'id' => $this->leaveRequest->id,
            'type' => 'leave_request',
            'title' => $title,
            'message' => $message,
            'comment' => $this->comment,
            'url' => $url,
            'leave_request_id' => $this->leaveRequest->id,
            'created_at' => now(),
            'action_type' => $this->type
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toDatabase($notifiable));
    }
}
