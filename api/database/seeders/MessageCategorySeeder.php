<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MessageCategory;

class MessageCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Ogłoszenia'],
            ['name' => 'Informacje'],
            ['name' => 'Ważne'],
            ['name' => 'HR'],
            ['name' => 'IT'],
            ['name' => 'Administracja'],
            ['name' => 'Marketing'],
            ['name' => 'Newsletter'],
            ['name' => 'Spotkania'],
            ['name' => 'Szkolenia'],
        ];

        foreach ($categories as $category) {
            MessageCategory::create($category);
        }
    }
}
