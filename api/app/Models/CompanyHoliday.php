<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyHoliday extends Model
{
    protected $fillable = [
        'organization_id', 'name', 'date', 'recurring_yearly'
    ];

    protected $casts = [
        'date' => 'date',
        'recurring_yearly' => 'boolean'
    ];

    public function organization() {
        return $this->belongsTo(Organization::class);
    }
}
