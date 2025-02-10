<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalProcess extends Model
{
    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function steps()
    {
        return $this->hasMany(ApprovalStep::class)->orderBy('order');
    }
}
