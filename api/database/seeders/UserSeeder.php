<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
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
                'health_check_expired_by' => '2026-01-01',
                'health_and_safety_training_expired_by' => '2024-01-01'
            ],
            [
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
                'health_check_expired_by' => '2026-01-01',
                'health_and_safety_training_expired_by' => '2024-01-01'
            ],
            [
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
                'health_check_expired_by' => '2026-11-12',
                'health_and_safety_training_expired_by' => '2021-06-11'
            ],
            [
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
                'health_check_expired_by' => '2025-03-10',
                'health_and_safety_training_expired_by' => '2024-03-01'
            ],
            [
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
                'health_check_expired_by' => '2025-05-15',
                'health_and_safety_training_expired_by' => '2024-06-01'
            ],
            [
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
                'health_check_expired_by' => '2025-12-20',
                'health_and_safety_training_expired_by' => '2024-01-15'
            ],
            [
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
                'health_check_expired_by' => '2026-03-10',
                'health_and_safety_training_expired_by' => '2024-03-15'
            ],
            [
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
                'health_check_expired_by' => '2024-12-25',
                'health_and_safety_training_expired_by' => '2024-01-01'
            ],
            [
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
                'health_check_expired_by' => '2025-09-15',
                'health_and_safety_training_expired_by' => '2024-09-01'
            ],
            [
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
                'health_check_expired_by' => '2025-06-30',
                'health_and_safety_training_expired_by' => '2024-07-01'
            ],
            [
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
                'health_check_expired_by' => '2025-02-28',
                'health_and_safety_training_expired_by' => '2024-03-01'
            ],
            [
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
                'health_check_expired_by' => '2024-11-15',
                'health_and_safety_training_expired_by' => '2023-11-15'
            ],
            [
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
                'health_check_expired_by' => '2026-01-15',
                'health_and_safety_training_expired_by' => '2024-01-15'
            ],
            [
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
                'health_check_expired_by' => '2025-04-01',
                'health_and_safety_training_expired_by' => '2024-04-01'
            ],
            [
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
                'health_check_expired_by' => '2025-05-31',
                'health_and_safety_training_expired_by' => '2024-06-01'
            ],
            [
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
                'health_check_expired_by' => '2024-09-15',
                'health_and_safety_training_expired_by' => '2023-09-15'
            ],
            [
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
                'health_check_expired_by' => '2025-03-01',
                'health_and_safety_training_expired_by' => '2024-03-01'
            ],
            [
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
                'health_check_expired_by' => '2024-09-01',
                'health_and_safety_training_expired_by' => '2023-09-01'
            ],
            [
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
                'health_check_expired_by' => '2025-05-14',
                'health_and_safety_training_expired_by' => '2024-05-15'
            ],
            [
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
                'health_check_expired_by' => '2025-02-01',
                'health_and_safety_training_expired_by' => '2024-02-01'
            ]
        ];
        DB::table('users')->insert($users);
    }
}
