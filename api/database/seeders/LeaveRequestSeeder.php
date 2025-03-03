<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaveRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leaveRequests = [
            // Jan Kowalski (Android Developer) - 3 wnioski
            [
                'user_id' => 3,
                'leave_type_id' => 1, // Urlop wypoczynkowy
                'approval_process_id' => 3, // Android Developer - zatwierdza CTO
                'date_from' => '2025-07-01',
                'date_to' => '2025-07-14',
                'days_count' => 10,
                'reason' => 'Wakacje z rodziną',
                'comment' => null,
                'status' => 'APPROVED',
                'current_approval_step' => 1
            ],
            [
                'user_id' => 3,
                'leave_type_id' => 2, // Urlop na żądanie
                'approval_process_id' => 3, // Android Developer - zatwierdza CTO
                'date_from' => '2025-03-10',
                'date_to' => '2025-03-10',
                'days_count' => 1,
                'reason' => 'Sprawy osobiste',
                'comment' => 'Wizyta lekarska',
                'status' => 'APPROVED',
                'current_approval_step' => 1
            ],
            [
                'user_id' => 3,
                'leave_type_id' => 4, // Urlop szkoleniowy
                'approval_process_id' => 3, // Android Developer - zatwierdza CTO
                'date_from' => '2025-05-05',
                'date_to' => '2025-05-09',
                'days_count' => 5,
                'reason' => 'Szkolenie Flutter',
                'comment' => 'Kurs zaawansowany',
                'status' => 'IN_PROGRESS',
                'current_approval_step' => 1
            ],

            // Anna Nowak (HR Specialist) - 6 wniosków
            [
                'user_id' => 4,
                'leave_type_id' => 1, // Urlop wypoczynkowy
                'approval_process_id' => 4, // HR Spec - zatwierdza HR Director i CEO
                'date_from' => '2025-01-13',
                'date_to' => '2025-01-24',
                'days_count' => 10,
                'reason' => 'Urlop zimowy',
                'comment' => null,
                'status' => 'APPROVED',
                'current_approval_step' => 2
            ],
            [
                'user_id' => 4,
                'leave_type_id' => 2, // Urlop na żądanie
                'approval_process_id' => 4, // HR Spec - zatwierdza HR Director i CEO
                'date_from' => '2025-02-14',
                'date_to' => '2025-02-14',
                'days_count' => 1,
                'reason' => 'Sprawy osobiste',
                'comment' => 'Ważna sprawa rodzinna',
                'status' => 'APPROVED',
                'current_approval_step' => 2
            ],
            [
                'user_id' => 4,
                'leave_type_id' => 1, // Urlop wypoczynkowy
                'approval_process_id' => 4, // HR Spec - zatwierdza HR Director i CEO
                'date_from' => '2025-04-14',
                'date_to' => '2025-04-25',
                'days_count' => 10,
                'reason' => 'Urlop wypoczynkowy w Grecji',
                'comment' => null,
                'status' => 'REJECTED',
                'current_approval_step' => 1
            ],
            [
                'user_id' => 4,
                'leave_type_id' => 1, // Urlop wypoczynkowy
                'approval_process_id' => 4, // HR Spec - zatwierdza HR Director i CEO
                'date_from' => '2025-06-16',
                'date_to' => '2025-06-27',
                'days_count' => 10,
                'reason' => 'Wakacje nad morzem',
                'comment' => null,
                'status' => 'IN_PROGRESS',
                'current_approval_step' => 1
            ],
            [
                'user_id' => 4,
                'leave_type_id' => 4, // Urlop szkoleniowy
                'approval_process_id' => 4, // HR Spec - zatwierdza HR Director i CEO
                'date_from' => '2025-05-15',
                'date_to' => '2025-05-16',
                'days_count' => 2,
                'reason' => 'Szkolenie z zarządzania zespołem',
                'comment' => 'Szkolenie online w biurze',
                'status' => 'SENT',
                'current_approval_step' => 0
            ],
            [
                'user_id' => 4,
                'leave_type_id' => 2, // Urlop na żądanie
                'approval_process_id' => 4, // HR Spec - zatwierdza HR Director i CEO
                'date_from' => '2025-05-02',
                'date_to' => '2025-05-02',
                'days_count' => 1,
                'reason' => 'Wizyta lekarska',
                'comment' => null,
                'status' => 'DRAFT',
                'current_approval_step' => 0
            ],

            // Piotr Wiśniewski (Frontend Developer) - 3 wnioski
            [
                'user_id' => 5,
                'leave_type_id' => 1, // Urlop wypoczynkowy
                'approval_process_id' => 5, // Frontend Dev - zatwierdza CTO
                'date_from' => '2025-03-15',
                'date_to' => '2025-03-26',
                'days_count' => 8,
                'reason' => 'Wyjazd na narty',
                'comment' => null,
                'status' => 'APPROVED',
                'current_approval_step' => 1
            ],
            [
                'user_id' => 5,
                'leave_type_id' => 4, // Urlop szkoleniowy
                'approval_process_id' => 5, // Frontend Dev - zatwierdza CTO
                'date_from' => '2025-06-02',
                'date_to' => '2025-06-03',
                'days_count' => 2,
                'reason' => 'Szkolenie React',
                'comment' => 'Warsztaty zaawansowane',
                'status' => 'REJECTED',
                'current_approval_step' => 1
            ],
            [
                'user_id' => 5,
                'leave_type_id' => 2, // Urlop na żądanie
                'approval_process_id' => 5, // Frontend Dev - zatwierdza CTO
                'date_from' => '2025-02-14',
                'date_to' => '2025-02-14',
                'days_count' => 1,
                'reason' => 'Sprawy osobiste',
                'comment' => null,
                'status' => 'APPROVED',
                'current_approval_step' => 1
            ],

            // Tomasz Lewandowski (UX Designer) - 3 wnioski
            [
                'user_id' => 7,
                'leave_type_id' => 1, // Urlop wypoczynkowy
                'approval_process_id' => 7, // UX Designer - zatwierdza CTO
                'date_from' => '2025-05-19',
                'date_to' => '2025-05-30',
                'days_count' => 10,
                'reason' => 'Wakacje w Hiszpanii',
                'comment' => null,
                'status' => 'APPROVED',
                'current_approval_step' => 1
            ],
            [
                'user_id' => 7,
                'leave_type_id' => 4, // Urlop szkoleniowy
                'approval_process_id' => 7, // UX Designer - zatwierdza CTO
                'date_from' => '2025-04-10',
                'date_to' => '2025-04-11',
                'days_count' => 2,
                'reason' => 'Konferencja UX/UI',
                'comment' => 'Międzynarodowa konferencja w Warszawie',
                'status' => 'APPROVED',
                'current_approval_step' => 1
            ],
            [
                'user_id' => 7,
                'leave_type_id' => 2, // Urlop na żądanie
                'approval_process_id' => 7, // UX Designer - zatwierdza CTO
                'date_from' => '2025-03-03',
                'date_to' => '2025-03-03',
                'days_count' => 1,
                'reason' => 'Konieczność załatwienia spraw urzędowych',
                'comment' => null,
                'status' => 'APPROVED',
                'current_approval_step' => 1
            ],

            // Karolina Dąbrowska (Backend Developer) - 3 wnioski
            [
                'user_id' => 8,
                'leave_type_id' => 1, // Urlop wypoczynkowy
                'approval_process_id' => 8, // Backend Dev - zatwierdza CTO
                'date_from' => '2025-07-21',
                'date_to' => '2025-08-01',
                'days_count' => 10,
                'reason' => 'Urlop we Włoszech',
                'comment' => null,
                'status' => 'IN_PROGRESS',
                'current_approval_step' => 1
            ],
            [
                'user_id' => 8,
                'leave_type_id' => 2, // Urlop na żądanie
                'approval_process_id' => 8, // Backend Dev - zatwierdza CTO
                'date_from' => '2025-02-28',
                'date_to' => '2025-02-28',
                'days_count' => 1,
                'reason' => 'Ważne sprawy osobiste',
                'comment' => null,
                'status' => 'APPROVED',
                'current_approval_step' => 1
            ],
            [
                'user_id' => 8,
                'leave_type_id' => 4, // Urlop szkoleniowy
                'approval_process_id' => 8, // Backend Dev - zatwierdza CTO
                'date_from' => '2025-05-26',
                'date_to' => '2025-05-27',
                'days_count' => 2,
                'reason' => 'Szkolenie cloud computing',
                'comment' => 'Kurs AWS',
                'status' => 'SENT',
                'current_approval_step' => 0
            ],

            // Aleksandra Wojciechowska (QA Engineer) - 2 wnioski
            [
                'user_id' => 10,
                'leave_type_id' => 1, // Urlop wypoczynkowy
                'approval_process_id' => 10, // QA - zatwierdza CTO
                'date_from' => '2025-06-09',
                'date_to' => '2025-06-20',
                'days_count' => 10,
                'reason' => 'Wakacje rodzinne',
                'comment' => null,
                'status' => 'APPROVED',
                'current_approval_step' => 1
            ],
            [
                'user_id' => 10,
                'leave_type_id' => 3, // Urlop okolicznościowy
                'approval_process_id' => 10, // QA - zatwierdza CTO
                'date_from' => '2025-05-21',
                'date_to' => '2025-05-22',
                'days_count' => 2,
                'reason' => 'Ślub siostry',
                'comment' => null,
                'status' => 'IN_PROGRESS',
                'current_approval_step' => 1
            ],

            // Natalia Kamińska (UI Designer) - 2 wnioski
            [
                'user_id' => 14,
                'leave_type_id' => 1, // Urlop wypoczynkowy
                'approval_process_id' => 14, // UI Designer - zatwierdza CTO
                'date_from' => '2025-08-18',
                'date_to' => '2025-08-29',
                'days_count' => 10,
                'reason' => 'Wakacje w górach',
                'comment' => null,
                'status' => 'REJECTED',
                'current_approval_step' => 1
            ],
            [
                'user_id' => 14,
                'leave_type_id' => 4, // Urlop szkoleniowy
                'approval_process_id' => 14, // UI Designer - zatwierdza CTO
                'date_from' => '2025-04-24',
                'date_to' => '2025-04-25',
                'days_count' => 2,
                'reason' => 'Konferencja projektowa',
                'comment' => 'Design Summit 2025',
                'status' => 'APPROVED',
                'current_approval_step' => 1
            ],

            // Adam Piotrowski (Senior Backend Developer) - 2 wnioski
            [
                'user_id' => 15,
                'leave_type_id' => 1, // Urlop wypoczynkowy
                'approval_process_id' => 15, // Senior Backend - zatwierdza CTO
                'date_from' => '2025-09-08',
                'date_to' => '2025-09-19',
                'days_count' => 10,
                'reason' => 'Urlop wypoczynkowy w Chorwacji',
                'comment' => null,
                // TODO: REMOVE SENT STATUS, IN_PROGRESS COVERS IT
                'status' => 'SENT',
                'current_approval_step' => 0
            ],
            [
                'user_id' => 15,
                'leave_type_id' => 6, // Opieka nad dzieckiem
                'approval_process_id' => 15, // Senior Backend - zatwierdza CTO
                'date_from' => '2025-03-17',
                'date_to' => '2025-03-18',
                'days_count' => 2,
                'reason' => 'Opieka nad chorym dzieckiem',
                'comment' => null,
                'status' => 'APPROVED',
                'current_approval_step' => 1
            ],

            // Łukasz Michalski (System Administrator) - 2 wnioski
            [
                'user_id' => 17,
                'leave_type_id' => 1, // Urlop wypoczynkowy
                'approval_process_id' => 17, // System Admin - zatwierdza CTO
                'date_from' => '2025-08-11',
                'date_to' => '2025-08-22',
                'days_count' => 10,
                'reason' => 'Urlop w Grecji',
                'comment' => null,
                'status' => 'IN_PROGRESS',
                'current_approval_step' => 1
            ],
            [
                'user_id' => 17,
                'leave_type_id' => 4, // Urlop szkoleniowy
                'approval_process_id' => 17, // System Admin - zatwierdza CTO
                'date_from' => '2025-05-12',
                'date_to' => '2025-05-16',
                'days_count' => 5,
                'reason' => 'Szkolenie z cyberbezpieczeństwa',
                'comment' => 'Certyfikacja CISSP',
                'status' => 'APPROVED',
                'current_approval_step' => 1
            ],

            // Rafał Jankowski (iOS Developer) - 2 wnioski
            [
                'user_id' => 19,
                'leave_type_id' => 1, // Urlop wypoczynkowy
                'approval_process_id' => 19, // iOS Dev - zatwierdza CTO
                'date_from' => '2025-06-23',
                'date_to' => '2025-07-04',
                'days_count' => 10,
                'reason' => 'Urlop w Portugalii',
                'comment' => null,
                'status' => 'APPROVED',
                'current_approval_step' => 1
            ],
            [
                'user_id' => 19,
                'leave_type_id' => 4, // Urlop szkoleniowy
                'approval_process_id' => 19, // iOS Dev - zatwierdza CTO
                'date_from' => '2025-03-24',
                'date_to' => '2025-03-28',
                'days_count' => 5,
                'reason' => 'WWDC 2025',
                'comment' => 'Konferencja Apple dla developerów',
                'status' => 'CANCELLED',
                'current_approval_step' => 1
            ],
            [
                'user_id' => 20, // Katarzyna Adamczyk (Recruitment Specialist)
                'leave_type_id' => 1, // Urlop wypoczynkowy
                'approval_process_id' => 20, // Recruitment Specialist - zatwierdza HR Dir i CEO
                'date_from' => '2025-05-28',
                'date_to' => '2025-06-05',
                'days_count' => 7,
                'reason' => 'Wakacje we Włoszech',
                'comment' => null,
                'status' => 'IN_PROGRESS',
                'current_approval_step' => 1 // Pierwszy krok - czeka na zatwierdzenie przez Annę Nowak
            ]
        ];

        DB::table('leave_requests')->insert($leaveRequests);
    }
}
