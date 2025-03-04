<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyHolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = Organization::all();
        foreach ($organizations as $organization) {
            $holidays = [
                ['organization_id' => $organization->id, 'name' => 'Nowy Rok', 'date' => '2025-01-01', 'recurring_yearly' => true],
                ['organization_id' => $organization->id, 'name' => 'Święto Trzech Króli', 'date' => '2025-01-06', 'recurring_yearly' => true],
                ['organization_id' => $organization->id, 'name' => 'Święto Pracy', 'date' => '2025-05-01', 'recurring_yearly' => true],
                ['organization_id' => $organization->id, 'name' => 'Święto Konstytucji 3 Maja', 'date' => '2025-05-03', 'recurring_yearly' => true],
                ['organization_id' => $organization->id, 'name' => 'Wniebowzięcie Najświętszej Maryi Panny', 'date' => '2025-08-15', 'recurring_yearly' => true],
                ['organization_id' => $organization->id, 'name' => 'Wszystkich Świętych', 'date' => '2025-11-01', 'recurring_yearly' => true],
                ['organization_id' => $organization->id, 'name' => 'Święto Niepodległości', 'date' => '2025-11-11', 'recurring_yearly' => true],
                ['organization_id' => $organization->id, 'name' => 'Boże Narodzenie (pierwszy dzień)', 'date' => '2025-12-25', 'recurring_yearly' => true],
                ['organization_id' => $organization->id, 'name' => 'Boże Narodzenie (drugi dzień)', 'date' => '2025-12-26', 'recurring_yearly' => true],
            ];

            DB::table('company_holidays')->insert($holidays);
        }
    }
}
