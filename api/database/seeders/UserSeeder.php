<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // TODO: Fix the seeder cuz it's baad
        $currentYear = Carbon::now()->year;

        // Ustaw datę wygaśnięcia przeniesionych dni na 30 września bieżącego roku
        $transferredPtoExpiryDate = Carbon::createFromDate($currentYear, 9, 30)->format('Y-m-d');

        $users = [
            [
                'organization_id' => 1,
                'password' => bcrypt('password'),
                'first_name' => 'Marek',
                'last_name' => 'Jankowski',
                'sex' => 'M',
                'email' => 'm.jankowski@company.com',
                'birth_date' => '1975-08-15',
                'phone_number' => '+48505123789',
                'address_id' => 1,
                'job_title' => 'CEO',
                'supervisor_id' => null,
                'approval_process_id' => 1,
                'type_of_employment' => 'UoP',
                'paid_time_off_days' => 26,
                'working_time' => 1,
                'employed_from' => '2019-01-01',
                'employed_to' => null,
                'available_pto' => 26, // Pełen wymiar urlopu
                'pending_pto' => 0, // Brak wniosków w trakcie
                'transferred_pto' => 4, // Przeniesione dni z poprzedniego roku
                'transferred_pto_expired_by' => $transferredPtoExpiryDate,
                'health_check_expired_by' => '2026-01-01',
                'health_and_safety_training_expired_by' => '2024-01-01'
            ],
            [
                'organization_id' => 1,
                'password' => bcrypt('password'),
                'first_name' => 'Andrzej',
                'last_name' => 'Siwy',
                'sex' => 'M',
                'email' => 'a.siwy@company.com',
                'birth_date' => '1980-06-28',
                'phone_number' => '+48602345987',
                'address_id' => 2,
                'job_title' => 'CTO',
                'supervisor_id' => 1,
                'approval_process_id' => 2,
                'type_of_employment' => 'UoP',
                'paid_time_off_days' => 26,
                'working_time' => 1,
                'employed_from' => '2019-01-01',
                'employed_to' => null,
                'available_pto' => 26, // Pełen wymiar urlopu
                'pending_pto' => 0, // Brak wniosków w trakcie
                'transferred_pto' => 5, // Przeniesione dni z poprzedniego roku
                'transferred_pto_expired_by' => $transferredPtoExpiryDate,
                'health_check_expired_by' => '2026-01-01',
                'health_and_safety_training_expired_by' => '2024-01-01'
            ],
            [
                'organization_id' => 1,
                'password' => bcrypt('password'),
                'first_name' => 'Jan',
                'last_name' => 'Kowalski',
                'sex' => 'M',
                'email' => 'j.kowalski@company.com',
                'birth_date' => '1987-11-03',
                'phone_number' => '+48221389987',
                'address_id' => 3,
                'job_title' => 'Android Developer',
                'supervisor_id' => 2,
                'approval_process_id' => 3,
                'type_of_employment' => 'UoP',
                'paid_time_off_days' => 26,
                'working_time' => 0.5,
                'employed_from' => '2022-01-15',
                'employed_to' => null,
                // 26 dni * 0.5 etatu = 13 dni rocznie
                // Zatwierdzone wnioski: 10 dni (wakacje) + 1 dzień (urlop na żądanie) = 11 dni
                // W trakcie: 5 dni (szkolenie Flutter)
                // Pozostało: 13 - 11 = 2 dni z rocznej puli
                'available_pto' => 2, // Pozostałe dni po zatwierdzonych urlopach
                'pending_pto' => 5, // 5 dni (szkolenie Flutter) w trakcie rozpatrywania
                'transferred_pto' => 6, // Przeniesione dni z poprzedniego roku
                'transferred_pto_expired_by' => $transferredPtoExpiryDate,
                'health_check_expired_by' => '2026-11-12',
                'health_and_safety_training_expired_by' => '2021-06-11'
            ],
            [
                'organization_id' => 1,
                'password' => bcrypt('password'),
                'first_name' => 'Anna',
                'last_name' => 'Nowak',
                'sex' => 'F',
                'email' => 'a.nowak@company.com',
                'birth_date' => '1992-04-15',
                'phone_number' => '+48504678123',
                'address_id' => 4,
                'job_title' => 'HR Specialist',
                'supervisor_id' => 1,
                'approval_process_id' => 4,
                'type_of_employment' => 'UoP',
                'paid_time_off_days' => 26,
                'working_time' => 1,
                'employed_from' => '2021-03-01',
                'employed_to' => null,
                // Zatwierdzone wnioski: 10 dni (urlop zimowy) + 1 dzień (urlop na żądanie) = 11 dni
                // Odrzucone: 10 dni (Grecja)
                // W trakcie: 10 dni (wakacje nad morzem) + 2 dni (szkolenie) = 12 dni
                // Wersja robocza: 1 dzień (wizyta lekarska)
                // Pozostało: 26 - 11 = 15 dni z rocznej puli
                'available_pto' => 15, // Pozostałe dni po zatwierdzonych urlopach
                'pending_pto' => 12, // 12 dni w trakcie rozpatrywania
                'transferred_pto' => 3, // Przeniesione dni z poprzedniego roku
                'transferred_pto_expired_by' => $transferredPtoExpiryDate,
                'health_check_expired_by' => '2025-03-10',
                'health_and_safety_training_expired_by' => '2024-03-01'
            ],
            [
                'organization_id' => 1,
                'password' => bcrypt('password'),
                'first_name' => 'Piotr',
                'last_name' => 'Wiśniewski',
                'sex' => 'M',
                'email' => 'p.wisniewski@company.com',
                'birth_date' => '1985-07-22',
                'phone_number' => '+48602345678',
                'address_id' => 5,
                'job_title' => 'Frontend Developer',
                'supervisor_id' => 2,
                'approval_process_id' => 5,
                'type_of_employment' => 'B2B',
                'paid_time_off_days' => 20,
                'working_time' => 1,
                'employed_from' => '2023-06-01',
                'employed_to' => '2024-05-31',
                // Zatwierdzone wnioski: 8 dni (narty) + 1 dzień (urlop na żądanie) = 9 dni
                // Odrzucone: 2 dni (szkolenie React)
                // Pozostało: 20 - 9 = 11 dni z rocznej puli
                'available_pto' => 11, // Pozostałe dni po zatwierdzonych urlopach
                'pending_pto' => 0, // Brak wniosków w trakcie
                'transferred_pto' => 0, // B2B nie ma przeniesionych dni
                'transferred_pto_expired_by' => $transferredPtoExpiryDate,
                'health_check_expired_by' => '2025-05-15',
                'health_and_safety_training_expired_by' => '2024-06-01'
            ],
            [
                'organization_id' => 1,
                'password' => bcrypt('password'),
                'first_name' => 'Maria',
                'last_name' => 'Wiśniewska',
                'sex' => 'F',
                'email' => 'm.wisniewska@company.com',
                'birth_date' => '1978-12-01',
                'phone_number' => '+48505123456',
                'address_id' => 6,
                'job_title' => 'HR Director',
                'supervisor_id' => 1,
                'approval_process_id' => 6,
                'type_of_employment' => 'UoP',
                'paid_time_off_days' => 26,
                'working_time' => 1,
                'employed_from' => '2019-01-01',
                'employed_to' => null,
                'available_pto' => 26, // Pełen wymiar urlopu (brak wniosków w danych)
                'pending_pto' => 0, // Brak wniosków w trakcie
                'transferred_pto' => 7, // Przeniesione dni z poprzedniego roku
                'transferred_pto_expired_by' => $transferredPtoExpiryDate,
                'health_check_expired_by' => '2025-12-20',
                'health_and_safety_training_expired_by' => '2024-01-15'
            ],
            [
                'organization_id' => 1,
                'password' => bcrypt('password'),
                'first_name' => 'Tomasz',
                'last_name' => 'Lewandowski',
                'sex' => 'M',
                'email' => 't.lewandowski@company.com',
                'birth_date' => '1990-09-11',
                'phone_number' => '+48603234567',
                'address_id' => 7,
                'job_title' => 'UX Designer',
                'supervisor_id' => 2,
                'approval_process_id' => 7,
                'type_of_employment' => 'UoP',
                'paid_time_off_days' => 26,
                'working_time' => 1,
                'employed_from' => '2022-03-15',
                'employed_to' => null,
                // Zatwierdzone wnioski: 10 dni (Hiszpania) + 2 dni (konferencja) + 1 dzień (sprawy urzędowe) = 13 dni
                // Pozostało: 26 - 13 = 13 dni z rocznej puli
                'available_pto' => 13, // Pozostałe dni po zatwierdzonych urlopach
                'pending_pto' => 0, // Brak wniosków w trakcie
                'transferred_pto' => 2, // Przeniesione dni z poprzedniego roku
                'transferred_pto_expired_by' => $transferredPtoExpiryDate,
                'health_check_expired_by' => '2026-03-10',
                'health_and_safety_training_expired_by' => '2024-03-15'
            ],
            [
                'organization_id' => 1,
                'password' => bcrypt('password'),
                'first_name' => 'Karolina',
                'last_name' => 'Dąbrowska',
                'sex' => 'F',
                'email' => 'k.dabrowska@company.com',
                'birth_date' => '1993-03-25',
                'phone_number' => '+48504987654',
                'address_id' => 8,
                'job_title' => 'Backend Developer',
                'supervisor_id' => 2,
                'approval_process_id' => 8,
                'type_of_employment' => 'B2B',
                'paid_time_off_days' => 20,
                'working_time' => 0.8,
                'employed_from' => '2023-01-01',
                'employed_to' => '2024-12-31',
                // Przysługuje: 20 dni * 0.8 etatu = 16 dni
                // Zatwierdzone wnioski: 1 dzień (urlop na żądanie)
                // W trakcie: 10 dni (urlop we Włoszech) + 2 dni (szkolenie cloud) = 12 dni
                // Pozostało: 16 - 1 = 15 dni z rocznej puli
                'available_pto' => 15, // Pozostałe dni po zatwierdzonych urlopach
                'pending_pto' => 12, // 12 dni w trakcie rozpatrywania
                'transferred_pto' => 0, // B2B nie ma przeniesionych dni
                'transferred_pto_expired_by' => $transferredPtoExpiryDate,
                'health_check_expired_by' => '2024-12-25',
                'health_and_safety_training_expired_by' => '2024-01-01'
            ],
            [
                'organization_id' => 1,
                'password' => bcrypt('password'),
                'first_name' => 'Michał',
                'last_name' => 'Zieliński',
                'sex' => 'M',
                'email' => 'm.zielinski@company.com',
                'birth_date' => '1988-06-18',
                'phone_number' => '+48602123456',
                'address_id' => 9,
                'job_title' => 'Project Manager',
                'supervisor_id' => 1,
                'approval_process_id' => 9,
                'type_of_employment' => 'UoP',
                'paid_time_off_days' => 26,
                'working_time' => 1,
                'employed_from' => '2020-09-01',
                'employed_to' => null,
                'available_pto' => 26, // Pełen wymiar urlopu (brak wniosków w danych)
                'pending_pto' => 0, // Brak wniosków w trakcie
                'transferred_pto' => 0, // Brak przeniesionych dni
                'transferred_pto_expired_by' => $transferredPtoExpiryDate,
                'health_check_expired_by' => '2025-09-15',
                'health_and_safety_training_expired_by' => '2024-09-01'
            ],
            [
                'organization_id' => 1,
                'password' => bcrypt('password'),
                'first_name' => 'Aleksandra',
                'last_name' => 'Wojciechowska',
                'sex' => 'F',
                'email' => 'a.wojciechowska@company.com',
                'birth_date' => '1991-11-30',
                'phone_number' => '+48505678901',
                'address_id' => 10,
                'job_title' => 'QA Engineer',
                'supervisor_id' => 2,
                'approval_process_id' => 10,
                'type_of_employment' => 'UoP',
                'paid_time_off_days' => 26,
                'working_time' => 1,
                'employed_from' => '2022-07-01',
                'employed_to' => null,
                // Zatwierdzone wnioski: 10 dni (wakacje rodzinne)
                // W trakcie: 2 dni (ślub siostry)
                // Pozostało: 26 - 10 = 16 dni z rocznej puli
                'available_pto' => 16, // Pozostałe dni po zatwierdzonych urlopach
                'pending_pto' => 2, // 2 dni w trakcie rozpatrywania
                'transferred_pto' => 0, // Brak przeniesionych dni
                'transferred_pto_expired_by' => $transferredPtoExpiryDate,
                'health_check_expired_by' => '2025-06-30',
                'health_and_safety_training_expired_by' => '2024-07-01'
            ],
            [
                'organization_id' => 1,
                'password' => bcrypt('password'),
                'first_name' => 'Marcin',
                'last_name' => 'Kaczmarek',
                'sex' => 'M',
                'email' => 'm.kaczmarek@company.com',
                'birth_date' => '1986-02-14',
                'phone_number' => '+48603345678',
                'address_id' => 11,
                'job_title' => 'DevOps Engineer',
                'supervisor_id' => 2,
                'approval_process_id' => 11,
                'type_of_employment' => 'B2B',
                'paid_time_off_days' => 20,
                'working_time' => 1,
                'employed_from' => '2023-03-01',
                'employed_to' => '2025-02-28',
                'available_pto' => 20, // Pełen wymiar urlopu (brak wniosków w danych)
                'pending_pto' => 0, // Brak wniosków w trakcie
                'transferred_pto' => 0, // B2B nie ma przeniesionych dni
                'transferred_pto_expired_by' => $transferredPtoExpiryDate,
                'health_check_expired_by' => '2025-02-28',
                'health_and_safety_training_expired_by' => '2024-03-01'
            ],
            [
                'organization_id' => 1,
                'password' => bcrypt('password'),
                'first_name' => 'Magdalena',
                'last_name' => 'Szymańska',
                'sex' => 'F',
                'email' => 'm.szymanska@company.com',
                'birth_date' => '1994-08-07',
                'phone_number' => '+48504234567',
                'address_id' => 12,
                'job_title' => 'Marketing Specialist',
                'supervisor_id' => 1,
                'approval_process_id' => 12,
                'type_of_employment' => 'UoP',
                'paid_time_off_days' => 26,
                'working_time' => 0.75,
                'employed_from' => '2022-11-15',
                'employed_to' => null,
                // Przysługuje: 26 dni * 0.75 etatu = 19.5 dni (zaokrąglone do 20 dni)
                'available_pto' => 20, // Pełen wymiar urlopu (brak wniosków w danych)
                'pending_pto' => 0, // Brak wniosków w trakcie
                'transferred_pto' => 1, // Przeniesione dni z poprzedniego roku
                'transferred_pto_expired_by' => $transferredPtoExpiryDate,
                'health_check_expired_by' => '2024-11-15',
                'health_and_safety_training_expired_by' => '2023-11-15'
            ],
            [
                'organization_id' => 1,
                'password' => bcrypt('password'),
                'first_name' => 'Krzysztof',
                'last_name' => 'Wójcik',
                'sex' => 'M',
                'email' => 'k.wojcik@company.com',
                'birth_date' => '1983-05-19',
                'phone_number' => '+48602456789',
                'address_id' => 13,
                'job_title' => 'Sales Manager',
                'supervisor_id' => 1,
                'approval_process_id' => 13,
                'type_of_employment' => 'UoP',
                'paid_time_off_days' => 26,
                'working_time' => 1,
                'employed_from' => '2020-01-15',
                'employed_to' => null,
                'available_pto' => 26, // Pełen wymiar urlopu (brak wniosków w danych)
                'pending_pto' => 0, // Brak wniosków w trakcie
                'transferred_pto' => 3, // Przeniesione dni z poprzedniego roku
                'transferred_pto_expired_by' => $transferredPtoExpiryDate,
                'health_check_expired_by' => '2026-01-15',
                'health_and_safety_training_expired_by' => '2024-01-15'
            ],
            [
                'organization_id' => 1,
                'password' => bcrypt('password'),
                'first_name' => 'Natalia',
                'last_name' => 'Kamińska',
                'sex' => 'F',
                'email' => 'n.kaminska@company.com',
                'birth_date' => '1989-09-23',
                'phone_number' => '+48505789012',
                'address_id' => 14,
                'job_title' => 'UI Designer',
                'supervisor_id' => 2,
                'approval_process_id' => 14,
                'type_of_employment' => 'UoP',
                'paid_time_off_days' => 26,
                'working_time' => 0.5,
                'employed_from' => '2023-04-01',
                'employed_to' => null,
                // Przysługuje: 26 dni * 0.5 etatu = 13 dni
                // Odrzucone wnioski: 10 dni (wakacje w górach)
                // Zatwierdzone wnioski: 2 dni (konferencja projektowa)
                // Pozostało: 13 - 2 = 11 dni z rocznej puli
                'available_pto' => 11, // Pozostałe dni po zatwierdzonych urlopach
                'pending_pto' => 0, // Brak wniosków w trakcie
                'transferred_pto' => 0, // Brak przeniesionych dni (zatrudniona od 2023)
                'transferred_pto_expired_by' => $transferredPtoExpiryDate,
                'health_check_expired_by' => '2025-04-01',
                'health_and_safety_training_expired_by' => '2024-04-01'
            ],
            [
                'organization_id' => 1,
                'password' => bcrypt('password'),
                'first_name' => 'Adam',
                'last_name' => 'Piotrowski',
                'sex' => 'M',
                'email' => 'a.piotrowski@company.com',
                'birth_date' => '1987-12-12',
                'phone_number' => '+48603567890',
                'address_id' => 15,
                'job_title' => 'Senior Backend Developer',
                'supervisor_id' => 2,
                'approval_process_id' => 15,
                'type_of_employment' => 'B2B',
                'paid_time_off_days' => 20,
                'working_time' => 1,
                'employed_from' => '2021-06-01',
                'employed_to' => '2024-05-31',
                // Zatwierdzone wnioski: 2 dni (opieka nad dzieckiem)
                // W trakcie: 10 dni (Chorwacja)
                // Pozostało: 20 - 2 = 18 dni z rocznej puli
                'available_pto' => 18, // Pozostałe dni po zatwierdzonych urlopach
                'pending_pto' => 10, // 10 dni w trakcie rozpatrywania
                'transferred_pto' => 0, // B2B nie ma przeniesionych dni
                'transferred_pto_expired_by' => $transferredPtoExpiryDate,
                'health_check_expired_by' => '2025-05-31',
                'health_and_safety_training_expired_by' => '2024-06-01'
            ],
            [
                'organization_id' => 1,
                'password' => bcrypt('password'),
                'first_name' => 'Monika',
                'last_name' => 'Pawlak',
                'sex' => 'F',
                'email' => 'm.pawlak@company.com',
                'birth_date' => '1992-02-28',
                'phone_number' => '+48504345678',
                'address_id' => 16,
                'job_title' => 'Content Writer',
                'supervisor_id' => 1,
                'approval_process_id' => 16,
                'type_of_employment' => 'UoP',
                'paid_time_off_days' => 26,
                'working_time' => 0.75,
                'employed_from' => '2022-09-15',
                'employed_to' => null,
                // Przysługuje: 26 dni * 0.75 etatu = 19.5 dni (zaokrąglone do 20 dni)
                'available_pto' => 20, // Pełen wymiar urlopu (brak wniosków w danych)
                'pending_pto' => 0, // Brak wniosków w trakcie
                'transferred_pto' => 0, // Brak przeniesionych dni
                'transferred_pto_expired_by' => $transferredPtoExpiryDate,
                'health_check_expired_by' => '2024-09-15',
                'health_and_safety_training_expired_by' => '2023-09-15'
            ],
            [
                'organization_id' => 1,
                'password' => bcrypt('password'),
                'first_name' => 'Łukasz',
                'last_name' => 'Michalski',
                'sex' => 'M',
                'email' => 'l.michalski@company.com',
                'birth_date' => '1984-07-05',
                'phone_number' => '+48602678901',
                'address_id' => 17,
                'job_title' => 'System Administrator',
                'supervisor_id' => 2,
                'approval_process_id' => 17,
                'type_of_employment' => 'UoP',
                'paid_time_off_days' => 26,
                'working_time' => 1,
                'employed_from' => '2020-03-01',
                'employed_to' => null,
                // Zatwierdzone wnioski: 5 dni (szkolenie z cyberbezpieczeństwa)
                // W trakcie: 10 dni (urlop w Grecji)
                // Pozostało: 26 - 5 = 21 dni z rocznej puli
                'available_pto' => 21, // Pozostałe dni po zatwierdzonych urlopach
                'pending_pto' => 10, // 10 dni w trakcie rozpatrywania
                'transferred_pto' => 0, // Brak przeniesionych dni
                'transferred_pto_expired_by' => $transferredPtoExpiryDate,
                'health_check_expired_by' => '2025-03-01',
                'health_and_safety_training_expired_by' => '2024-03-01'
            ],
            [
                'organization_id' => 1,
                'password' => bcrypt('password'),
                'first_name' => 'Agnieszka',
                'last_name' => 'Grabowska',
                'sex' => 'F',
                'email' => 'a.grabowska@company.com',
                'birth_date' => '1990-10-16',
                'phone_number' => '+48505890123',
                'address_id' => 18,
                'job_title' => 'Office Manager',
                'supervisor_id' => 6,
                'approval_process_id' => 18,
                'type_of_employment' => 'UoP',
                'paid_time_off_days' => 26,
                'working_time' => 1,
                'employed_from' => '2021-09-01',
                'employed_to' => null,
                'available_pto' => 26, // Pełen wymiar urlopu (brak wniosków w danych)
                'pending_pto' => 0, // Brak wniosków w trakcie
                'transferred_pto' => 2, // Przeniesione dni z poprzedniego roku
                'transferred_pto_expired_by' => $transferredPtoExpiryDate,
                'health_check_expired_by' => '2024-09-01',
                'health_and_safety_training_expired_by' => '2023-09-01'
            ],
            [
                'organization_id' => 1,
                'password' => bcrypt('password'),
                'first_name' => 'Rafał',
                'last_name' => 'Jankowski',
                'sex' => 'M',
                'email' => 'r.jankowski@company.com',
                'birth_date' => '1986-04-09',
                'phone_number' => '+48603789012',
                'address_id' => 19,
                'job_title' => 'iOS Developer',
                'supervisor_id' => 2,
                'approval_process_id' => 19,
                'type_of_employment' => 'B2B',
                'paid_time_off_days' => 20,
                'working_time' => 1,
                'employed_from' => '2022-05-15',
                'employed_to' => '2024-05-14',
                // Zatwierdzone wnioski: 10 dni (urlop w Portugalii)
                // Anulowane wnioski: 5 dni (WWDC 2025)
                // Pozostało: 20 - 10 = 10 dni z rocznej puli
                'available_pto' => 10, // Pozostałe dni po zatwierdzonych urlopach
                'pending_pto' => 0,
                'transferred_pto' => 0, // B2B nie ma przeniesionych dni
                'transferred_pto_expired_by' => $transferredPtoExpiryDate,
                'health_check_expired_by' => '2025-05-14',
                'health_and_safety_training_expired_by' => '2024-05-15'
            ],
            [
                'organization_id' => 1,
                'password' => bcrypt('password'),
                'first_name' => 'Katarzyna',
                'last_name' => 'Adamczyk',
                'sex' => 'F',
                'email' => 'k.adamczyk@company.com',
                'birth_date' => '1993-01-21',
                'phone_number' => '+48504901234',
                'address_id' => 20,
                'job_title' => 'Recruitment Specialist',
                'supervisor_id' => 6,
                'approval_process_id' => 20,
                'type_of_employment' => 'UoP',
                'paid_time_off_days' => 26,
                'working_time' => 0.8,
                'employed_from' => '2023-02-01',
                'employed_to' => null,
                // Przysługuje: 26 dni * 0.8 etatu = 20.8 dni (zaokrąglone do 21 dni)
                // W trakcie: 7 dni (wakacje we Włoszech)
                // Pozostało: 21 - 0 = 21 dni z rocznej puli, minus 7 dni w rozpatrzeniu
                'available_pto' => 21, // Pełna pula (brak zatwierdzonych wniosków)
                'pending_pto' => 7,
                'transferred_pto' => 0, // Brak przeniesionych dni (zatrudniona od 2023)
                'transferred_pto_expired_by' => $transferredPtoExpiryDate,
                'health_check_expired_by' => '2025-02-01',
                'health_and_safety_training_expired_by' => '2024-02-01'
            ]
        ];
        DB::table('users')->insert($users);
    }
}
