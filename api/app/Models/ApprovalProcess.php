<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalProcess extends Model
{
    protected $fillable = [
        'dummy'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
