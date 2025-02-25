<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaveRequestReplacementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $replacements = [
            // Jan Kowalski's replacements
            [
                'leave_request_id' => 1, // Wakacje z rodziną
                'user_id' => 19, // Rafał Jankowski (iOS Developer)
                'status' => 'APPROVED',
                'comment' => 'Potwierdzam zastępstwo'
            ],
            [
                'leave_request_id' => 2, // Urlop na żądanie - sprawy osobiste
                'user_id' => 5, // Piotr Wiśniewski (Frontend Developer)
                'status' => 'APPROVED',
                'comment' => 'Ok, zastąpię'
            ],
            [
                'leave_request_id' => 3, // Szkolenie Flutter
                'user_id' => 19, // Rafał Jankowski (iOS Developer)
                'status' => 'IN_PROGRESS',
                'comment' => null
            ],

            // Anna Nowak's replacements
            [
                'leave_request_id' => 4, // Urlop zimowy
                'user_id' => 20, // Katarzyna Adamczyk (Recruitment Specialist)
                'status' => 'APPROVED',
                'comment' => 'Potwierdzam zastępstwo'
            ],
            [
                'leave_request_id' => 5, // Urlop na żądanie - sprawy osobiste
                'user_id' => 20, // Katarzyna Adamczyk (Recruitment Specialist)
                'status' => 'APPROVED',
                'comment' => 'OK, zastąpię'
            ],
            [
                'leave_request_id' => 6, // Odrzucony wniosek na Grecję
                'user_id' => 20, // Katarzyna Adamczyk (Recruitment Specialist)
                'status' => 'REJECTED',
                'comment' => 'Niestety nie mogę w tym terminie'
            ],
            [
                'leave_request_id' => 7, // Wakacje nad morzem - w trakcie
                'user_id' => 20, // Katarzyna Adamczyk (Recruitment Specialist)
                'status' => 'IN_PROGRESS',
                'comment' => null
            ],
            [
                'leave_request_id' => 8, // Szkolenie - wysłany
                'user_id' => 20, // Katarzyna Adamczyk (Recruitment Specialist)
                'status' => 'IN_PROGRESS',
                'comment' => null
            ],

            // Piotr Wiśniewski's replacements
            [
                'leave_request_id' => 10, // Wyjazd na narty
                'user_id' => 15, // Adam Piotrowski (Senior Backend Developer)
                'status' => 'APPROVED',
                'comment' => 'Mogę zastąpić'
            ],
            [
                'leave_request_id' => 11, // Szkolenie React
                'user_id' => 8, // Karolina Dąbrowska (Backend Developer)
                'status' => 'REJECTED',
                'comment' => 'Niestety w tym terminie mam zaplanowane inne zadania'
            ],
            [
                'leave_request_id' => 12, // Urlop na żądanie - sprawy osobiste
                'user_id' => 3, // Jan Kowalski (Android Developer)
                'status' => 'APPROVED',
                'comment' => 'Ok'
            ],

            // Tomasz Lewandowski's replacements
            [
                'leave_request_id' => 13, // Wakacje w Hiszpanii
                'user_id' => 14, // Natalia Kamińska (UI Designer)
                'status' => 'APPROVED',
                'comment' => 'Potwierdzam zastępstwo'
            ],
            [
                'leave_request_id' => 14, // Konferencja UX/UI
                'user_id' => 14, // Natalia Kamińska (UI Designer)
                'status' => 'APPROVED',
                'comment' => 'Mogę zastąpić'
            ],
            [
                'leave_request_id' => 15, // Urlop na żądanie - sprawy urzędowe
                'user_id' => 14, // Natalia Kamińska (UI Designer)
                'status' => 'APPROVED',
                'comment' => 'Potwierdzam'
            ],

            // Karolina Dąbrowska's replacements
            [
                'leave_request_id' => 16, // Urlop we Włoszech
                'user_id' => 15, // Adam Piotrowski (Senior Backend Developer)
                'status' => 'IN_PROGRESS',
                'comment' => null
            ],
            [
                'leave_request_id' => 17, // Urlop na żądanie - sprawy osobiste
                'user_id' => 15, // Adam Piotrowski (Senior Backend Developer)
                'status' => 'APPROVED',
                'comment' => 'Ok, mogę zastąpić'
            ],
            [
                'leave_request_id' => 18, // Szkolenie cloud computing
                'user_id' => 15, // Adam Piotrowski (Senior Backend Developer)
                'status' => 'IN_PROGRESS',
                'comment' => null
            ],

            // Aleksandra Wojciechowska's replacements
            [
                'leave_request_id' => 19, // Wakacje rodzinne
                'user_id' => 3, // Jan Kowalski (Android Developer)
                'status' => 'APPROVED',
                'comment' => 'Potwierdzam zastępstwo'
            ],

            // Natalia Kamińska's replacements
            [
                'leave_request_id' => 21, // Wakacje w górach
                'user_id' => 7, // Tomasz Lewandowski (UX Designer)
                'status' => 'REJECTED',
                'comment' => 'Niestety nie mogę w tym terminie'
            ],
            [
                'leave_request_id' => 22, // Konferencja projektowa
                'user_id' => 7, // Tomasz Lewandowski (UX Designer)
                'status' => 'APPROVED',
                'comment' => 'Mogę zastąpić'
            ],

            // Adam Piotrowski's replacements
            [
                'leave_request_id' => 23, // Urlop w Chorwacji
                'user_id' => 8, // Karolina Dąbrowska (Backend Developer)
                'status' => 'IN_PROGRESS',
                'comment' => null
            ],

            // Łukasz Michalski's replacements
            [
                'leave_request_id' => 25, // Urlop w Grecji
                'user_id' => 11, // Marcin Kaczmarek (DevOps Engineer)
                'status' => 'IN_PROGRESS',
                'comment' => null
            ],
            [
                'leave_request_id' => 26, // Szkolenie z cyberbezpieczeństwa
                'user_id' => 11, // Marcin Kaczmarek (DevOps Engineer)
                'status' => 'APPROVED',
                'comment' => 'Potwierdzam'
            ],

            // Rafał Jankowski's replacements
            [
                'leave_request_id' => 27, // Urlop w Portugalii
                'user_id' => 3, // Jan Kowalski (Android Developer)
                'status' => 'APPROVED',
                'comment' => 'Zgadzam się na zastępstwo'
            ],
            [
                'leave_request_id' => 28, // WWDC 2025
                'user_id' => 3, // Jan Kowalski (Android Developer)
                'status' => 'APPROVED',
                'comment' => 'Mogę zastąpić'
            ]
        ];

        DB::table('leave_request_replacements')->insert($replacements);
    }
}
