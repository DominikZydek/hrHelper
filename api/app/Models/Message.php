<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'author_id', 'subject', 'message_category_id', 'content', 'priority',
        'publication_date', 'date_from', 'date_to', 'require_confirmation'
    ];

    public function category() {
        return $this->belongsTo(MessageCategory::class);
    }

    public function recipients()
    {
        return $this->belongsToMany(User::class, 'message_recipients', 'message_id', 'recipient_id')
            ->withPivot('seen')
            ->withTimestamps();
    }

    public function author() {
        return $this->belongsTo(User::class, 'author_id');
    }
}
