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

    public function holidays() {
        return $this->hasMany(CompanyHoliday::class);
    }

    public function media_collections()
    {
        return $this->hasMany(MediaCollection::class);
    }
}
