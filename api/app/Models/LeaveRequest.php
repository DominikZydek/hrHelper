<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $fillable = [
        'user_id', 'leave_type_id', 'approval_process_id', 'date_from', 'date_to',
        'days_count', 'reason', 'comment', 'status', 'current_approval_step'
    ];

    protected $casts = [
        'date_from' => 'date',
        'date_to' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leave_type()
    {
        return $this->belongsTo(LeaveType::class);
    }

    public function approval_process()
    {
        return $this->belongsTo(ApprovalProcess::class);
    }

    public function replacement()
    {
        return $this->hasOne(LeaveRequestReplacement::class);
    }

    public function approval_steps_history()
    {
        return $this->hasMany(ApprovalStepsHistory::class);
    }
}
