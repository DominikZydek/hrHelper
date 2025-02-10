<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalStep extends Model
{
    protected $fillable = [
        'approval_process_id', 'order', 'approver_id'
    ];

    public function process()
    {
        return $this->belongsTo(ApprovalProcess::class, 'approval_process_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
