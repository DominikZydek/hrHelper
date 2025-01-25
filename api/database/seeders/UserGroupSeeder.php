<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userGroups = [
            ['user_id' => 1, 'group_id' => 4],  // Marek Jankowski: Management
            ['user_id' => 1, 'group_id' => 17], // Board
            ['user_id' => 2, 'group_id' => 1],  // Andrzej Siwy: Tech
            ['user_id' => 2, 'group_id' => 4],  // Management
            ['user_id' => 2, 'group_id' => 17], // Board
            ['user_id' => 3, 'group_id' => 1],  // Jan Kowalski: Tech
            ['user_id' => 3, 'group_id' => 15], // Mobile
            ['user_id' => 4, 'group_id' => 2],  // Anna Nowak: HR
            ['user_id' => 4, 'group_id' => 3],  // Recruitment
            ['user_id' => 5, 'group_id' => 1],  // Piotr Wiśniewski: Tech
            ['user_id' => 5, 'group_id' => 5],  // Frontend
            ['user_id' => 6, 'group_id' => 2],  // Maria Wiśniewska: HR
            ['user_id' => 6, 'group_id' => 4],  // Management
            ['user_id' => 7, 'group_id' => 1],  // Tomasz Lewandowski: Tech
            ['user_id' => 7, 'group_id' => 7],  // Design
            ['user_id' => 8, 'group_id' => 1],  // Karolina Dąbrowska: Tech
            ['user_id' => 8, 'group_id' => 6],  // Backend
            ['user_id' => 9, 'group_id' => 1],  // Michał Zieliński: Tech
            ['user_id' => 9, 'group_id' => 4],  // Management
            ['user_id' => 10, 'group_id' => 1], // Aleksandra Wojciechowska: Tech
            ['user_id' => 10, 'group_id' => 8], // QA
            ['user_id' => 11, 'group_id' => 1], // Marcin Kaczmarek: Tech
            ['user_id' => 11, 'group_id' => 9], // DevOps
            ['user_id' => 12, 'group_id' => 10], // Magdalena Szymańska: Marketing
            ['user_id' => 13, 'group_id' => 11], // Krzysztof Wójcik: Sales
            ['user_id' => 13, 'group_id' => 4],  // Management
            ['user_id' => 14, 'group_id' => 1], // Natalia Kamińska: Tech
            ['user_id' => 14, 'group_id' => 7], // Design
            ['user_id' => 15, 'group_id' => 1], // Adam Piotrowski: Tech
            ['user_id' => 15, 'group_id' => 6], // Backend
            ['user_id' => 16, 'group_id' => 10], // Monika Pawlak: Marketing
            ['user_id' => 16, 'group_id' => 12], // Content
            ['user_id' => 17, 'group_id' => 1], // Łukasz Michalski: Tech
            ['user_id' => 17, 'group_id' => 13], // Infrastructure
            ['user_id' => 18, 'group_id' => 14], // Agnieszka Grabowska: Administration
            ['user_id' => 19, 'group_id' => 1], // Rafał Jankowski: Tech
            ['user_id' => 19, 'group_id' => 15], // Mobile
            ['user_id' => 20, 'group_id' => 2], // Katarzyna Adamczyk: HR
            ['user_id' => 20, 'group_id' => 3]  // Recruitment
        ];
        DB::table('user_groups')->insert($userGroups);
    }
}
