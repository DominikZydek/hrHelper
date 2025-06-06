<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'name', 'display_name', 'description'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }

    public function user_overrides()
    {
        return $this->belongsToMany(User::class, 'permission_overrides')
                    ->withPivot('granted');
    }
}
