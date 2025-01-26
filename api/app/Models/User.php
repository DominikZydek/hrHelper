<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'sex', 'email', 'birth_date', 'phone_number',
        'address_id', 'job_title', 'supervisor_id', 'approval_process_id', 'type_of_employment',
        'paid_time_off_days', 'working_time', 'employed_from', 'employed_to',
        'health_check_expired_by', 'health_and_safety_training_expired_by'
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    public function approval_process()
    {
        return $this->belongsTo(ApprovalProcess::class);
    }
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }
    public function subordinates()
    {
        return $this->hasMany(User::class, 'supervisor_id');
    }
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'user_groups');
    }
}
