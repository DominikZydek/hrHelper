<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageTemplate extends Model
{
    protected $fillable = [
        'name', 'subject', 'content', 'priority', 'require_confirmation', 'category_id'
    ];
}
