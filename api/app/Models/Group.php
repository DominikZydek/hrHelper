<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name', 'icon_name'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_groups');
    }
}
