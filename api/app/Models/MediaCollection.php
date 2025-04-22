<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaCollection extends Model
{
    protected $fillable = [
        'name', 'display_name', 'organization_id'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
