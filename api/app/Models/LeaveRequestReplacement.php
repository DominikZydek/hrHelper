<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequestReplacement extends Model
{
    protected $fillable = [
        'leave_request_id', 'user_id', 'status', 'comment'
    ];

    public function leave_request()
    {
        return $this->belongsTo(LeaveRequest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
