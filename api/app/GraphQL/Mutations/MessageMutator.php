<?php

namespace App\GraphQL\Mutations;

use App\Models\Message;
use App\Models\User;
use App\Notifications\NewMessageNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageMutator
{
    public function createMessage($root, array $args) {
        $currentUser = Auth::user();

        try {
            DB::beginTransaction();

            $message = Message::create([
                'author_id' => $currentUser->id,
                'subject' => $args['subject'],
                'message_category_id' => $args['category'],
                'content' => $args['content'],
                'priority' => $args['priority'],
                'publication_date' => $args['publication_date'],
                'date_from' => $args['date_from'] ?? null,
                'date_to' => $args['date_to'] ?? null,
                'require_confirmation' => $args['require_confirmation'],
            ]);

            $recipients = User::whereIn('id', $args['recipients'])->get();
            $message->recipients()->sync($args['recipients']);

            foreach ($recipients as $recipient) {
                $recipient->notify(new NewMessageNotification($message));
            }

            DB::commit();

            return $message;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to create message: ' . $e->getMessage());
        }
    }

    public function markMessageAsRead($root, array $args) {
        $currentUser = Auth::user();

        $message = $currentUser->messages()
            ->wherePivot('message_id', $args['message'])
            ->first();

        $message->pivot->seen = true;
        $message->pivot->save();

        return $message;
    }
}
