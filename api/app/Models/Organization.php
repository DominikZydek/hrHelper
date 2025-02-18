<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'alias', 'name'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
