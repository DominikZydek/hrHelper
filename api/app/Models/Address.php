<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'street_name', 'street_number', 'postal_code', 'city'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
