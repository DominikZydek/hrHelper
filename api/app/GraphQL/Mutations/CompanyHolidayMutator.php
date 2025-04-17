<?php

namespace App\GraphQL\Mutations;

use App\Models\CompanyHoliday;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompanyHolidayMutator
{
    public function createCompanyHoliday($root, array $args)
    {
        $currentUser = Auth::user();

        try {
            DB::beginTransaction();

            $holiday = CompanyHoliday::create([
                'name' => $args['name'],
                'date' => $args['date'],
                'recurring_yearly' => $args['recurring_yearly'],
                'organization_id' => $currentUser->organization_id,
            ]);

            DB::commit();
            return $holiday;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to create holiday: ' . $e->getMessage());
        }
    }
    public function editCompanyHoliday($root, array $args)
    {
        $currentUser = Auth::user();

        try {
            DB::beginTransaction();

            $holiday = CompanyHoliday::findOrFail($args['holiday']);

            $holiday->update([
                'name' => $args['name'],
                'date' => $args['date'],
                'recurring_yearly' => $args['recurring_yearly'],
            ]);

            DB::commit();
            return $holiday;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to update holiday: ' . $e->getMessage());
        }
    }

    public function removeCompanyHoliday($root, array $args)
    {
        $currentUser = Auth::user();

        try {
            DB::beginTransaction();

            $holiday = CompanyHoliday::findOrFail($args['holiday']);

            $holiday->delete();

            // TODO: check for existing leave requests which contain this day

            DB::commit();
            return $holiday;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to remove holiday: ' . $e->getMessage());
        }
    }
}
