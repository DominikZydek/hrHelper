<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageTemplate extends Model
{
    protected $fillable = [
        'name', 'subject', 'content', 'priority', 'require_confirmation', 'category_id'
    ];

    public function category()
    {
        return MessageTemplate::hasOne(MessageCategory::class, 'id', 'category_id');
    }
}
