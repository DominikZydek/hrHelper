<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalStepsHistory extends Model
{
    protected $fillable = [
        'leave_request_id', 'step', 'status', 'approver_id', 'comment', 'date'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];
    public function leave_request()
    {
        return $this->belongsTo(LeaveRequest::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
