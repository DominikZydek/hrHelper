<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    protected $fillable = [
        'organization_id', 'password',
        'first_name', 'last_name', 'sex', 'email', 'birth_date', 'phone_number',
        'address_id', 'role', 'job_title', 'supervisor_id', 'approval_process_id', 'type_of_employment',
        'paid_time_off_days', 'working_time', 'employed_from', 'employed_to',
        'health_check_expired_by', 'health_and_safety_training_expired_by'
    ];

    protected $casts = [
        'sex' => Sex::class,
        'role' => Role::class,
        'type_of_employment' => TypeOfEmployment::class,
        'birth_date' => 'date',
        'employed_from' => 'date',
        'employed_to' => 'date',
        'health_check_expired_by' => 'date',
        'health_and_safety_training_expired_by' => 'date',
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
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
}

enum Sex: string
{
    case M = 'M';
    case F = 'F';
    case X = 'X';
}
enum Role: string
{
    case EMPLOYEE = 'employee';
    case SUPERVISOR = 'supervisor';
    case HR = 'hr';
    case ADMIN = 'admin';
}
enum TypeOfEmployment: string
{
    case UOP = 'UoP';
    case B2B = 'B2B';
}
