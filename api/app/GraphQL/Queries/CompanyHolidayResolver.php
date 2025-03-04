<?php

namespace App\GraphQL\Queries;

use App\Models\CompanyHoliday;
use Illuminate\Support\Facades\Auth;

class CompanyHolidayResolver
{
    public function company_holidays($root, array $args)
    {
        $user = Auth::user();

        return CompanyHoliday::where('organization_id', $user->organization_id)
            ->orderBy('date')
            ->get();
    }
}
