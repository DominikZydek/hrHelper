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
        'address_id', 'job_title', 'supervisor_id', 'approval_process_id', 'type_of_employment',
        'paid_time_off_days', 'working_time', 'employed_from', 'employed_to',
        'available_pto', 'pending_pto', 'transferred_pto', 'transferred_pto_expired_by',
        'health_check_expired_by', 'health_and_safety_training_expired_by', 'activation_token'
    ];

    protected $casts = [
        'sex' => Sex::class,
        'type_of_employment' => TypeOfEmployment::class,
        'birth_date' => 'date',
        'employed_from' => 'date',
        'employed_to' => 'date',
        'transferred_pto_expired_by' => 'date',
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
    public function leave_requests()
    {
        return $this->hasMany(LeaveRequest::class);
    }
    public function replacement_requests()
    {
        return $this->hasMany(LeaveRequest::class);
    }
    public function approval_history_as_approver()
    {
        return $this->hasMany(ApprovalStepsHistory::class, 'approver_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_users');
    }

    public function permission_overrides()
    {
        return $this->belongsToMany(Permission::class, 'permission_overrides')
            ->withPivot('granted');
    }

    public function messages()
    {
        return $this->belongsToMany(Message::class, 'message_recipients', 'recipient_id')
            ->withPivot('seen')
            ->withTimestamps();
    }

    public function visibleMessages()
    {
        $query = $this->messages()
            ->where('publication_date', '<=', now());

        $query->where(function($q) {
            $q->whereNull('date_from')
                ->orWhere('date_from', '<=', now());
        });

        $query->where(function($q) {
            $q->whereNull('date_to')
                ->orWhere('date_to', '>=', now());
        });

        return $query;
    }

    /**
     * Checks if user has a specific permission
     */
    public function hasPermission($permissionName)
    {
        // 1. Check if permission is granted via override
        $override = $this->permission_overrides()
            ->where('permissions.name', $permissionName)
            ->first();

        if ($override) {
            return $override->pivot->granted;
        }

        // 2. Check if permission derives from the role
        foreach ($this->roles as $role) {
            if ($role->permissions()->where('permissions.name', $permissionName)->exists()) {
                return true;
            }
        }

        // permission not found
        return false;
    }

    /**
     * Checks if user has any of the provided permissions
     */
    public function hasAnyPermission($permissionNames)
    {
        if (is_string($permissionNames)) {
            $permissionNames = [$permissionNames];
        }

        foreach ($permissionNames as $permissionName) {
            if ($this->hasPermission($permissionName)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if user has all of the provided permissions
     */
    public function hasAllPermissions($permissionNames)
    {
        if (is_string($permissionNames)) {
            $permissionNames = [$permissionNames];
        }

        foreach ($permissionNames as $permissionName) {
            if (!$this->hasPermission($permissionName)) {
                return false;
            }
        }

        return true;
    }
}

enum Sex: string
{
    case M = 'M';
    case F = 'F';
    case X = 'X';
}
enum TypeOfEmployment: string
{
    case UOP = 'UoP';
    case B2B = 'B2B';
}
