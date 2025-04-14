<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name', 'icon_name', 'organization_id'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_groups');
    }
}
