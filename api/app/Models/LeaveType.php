<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    protected $fillable = [
        'name', 'limit_per_year', 'requires_replacement', 'min_notice_days', 'can_be_cancelled'
    ];

    protected $casts = [
        'requires_replacement' => 'boolean',
        'can_be_cancelled' => 'boolean',
    ];

    public function leave_requests()
    {
        return $this->hasMany(LeaveRequest::class);
    }
}
