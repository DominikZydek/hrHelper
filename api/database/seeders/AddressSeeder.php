<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $addresses = [
            ['street_name' => 'Krupnicza', 'street_number' => '16/4', 'postal_code' => '31-123', 'city' => 'Kraków'],
            ['street_name' => 'Sebastiana', 'street_number' => '9/15', 'postal_code' => '31-049', 'city' => 'Kraków'],
            ['street_name' => 'Ogrodowa', 'street_number' => '21/4', 'postal_code' => '33-109', 'city' => 'Wieliczka'],
            ['street_name' => 'Krakowska', 'street_number' => '45', 'postal_code' => '30-001', 'city' => 'Kraków'],
            ['street_name' => 'Długa', 'street_number' => '12/3', 'postal_code' => '31-124', 'city' => 'Kraków'],
            ['street_name' => 'Mickiewicza', 'street_number' => '8/12', 'postal_code' => '31-110', 'city' => 'Kraków'],
            ['street_name' => 'Słowackiego', 'street_number' => '15', 'postal_code' => '30-001', 'city' => 'Kraków'],
            ['street_name' => 'Poznańska', 'street_number' => '3/7', 'postal_code' => '30-012', 'city' => 'Kraków'],
            ['street_name' => 'Warszawska', 'street_number' => '22/5', 'postal_code' => '31-155', 'city' => 'Kraków'],
            ['street_name' => 'Dietla', 'street_number' => '45/12', 'postal_code' => '31-046', 'city' => 'Kraków'],
            ['street_name' => 'Lea', 'street_number' => '10/3', 'postal_code' => '30-049', 'city' => 'Kraków'],
            ['street_name' => 'Krowoderska', 'street_number' => '25/8', 'postal_code' => '31-142', 'city' => 'Kraków'],
            ['street_name' => 'Karmelicka', 'street_number' => '30/4', 'postal_code' => '31-128', 'city' => 'Kraków'],
            ['street_name' => 'Rajska', 'street_number' => '5/12', 'postal_code' => '31-124', 'city' => 'Kraków'],
            ['street_name' => 'Grodzka', 'street_number' => '15/3', 'postal_code' => '31-006', 'city' => 'Kraków'],
            ['street_name' => 'Szewska', 'street_number' => '8/7', 'postal_code' => '31-009', 'city' => 'Kraków'],
            ['street_name' => 'Wielopole', 'street_number' => '12/9', 'postal_code' => '31-072', 'city' => 'Kraków'],
            ['street_name' => 'Starowiślna', 'street_number' => '20/5', 'postal_code' => '31-038', 'city' => 'Kraków'],
            ['street_name' => 'Floriańska', 'street_number' => '25/8', 'postal_code' => '31-019', 'city' => 'Kraków'],
            ['street_name' => 'Brzozowa', 'street_number' => '7/3', 'postal_code' => '31-050', 'city' => 'Kraków']
        ];
        DB::table('addresses')->insert($addresses);
    }
}
