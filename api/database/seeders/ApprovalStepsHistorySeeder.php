<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApprovalStepsHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $approvalStepsHistory = [
            // Jan Kowalski - 1. Wakacje z rodziną
            [
                'leave_request_id' => 1,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => 'Utworzono wniosek urlopowy',
                'date' => '2025-06-01 14:20:00'
            ],
            [
                'leave_request_id' => 1,
                'step' => 0,
                'status' => 'SENT',
                'approver_id' => null,
                'comment' => 'Wysłano wniosek do akceptacji',
                'date' => '2025-06-01 14:30:00'
            ],
            [
                'leave_request_id' => 1,
                'step' => 1,
                'status' => 'APPROVED',
                'approver_id' => 2, // Andrzej Siwy (CTO)
                'comment' => 'Zatwierdzam urlop',
                'date' => '2025-06-02 09:45:00'
            ],

            // Jan Kowalski - 2. Urlop na żądanie
            [
                'leave_request_id' => 2,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => 'Utworzono wniosek urlopowy',
                'date' => '2025-03-10 08:00:00'
            ],
            [
                'leave_request_id' => 2,
                'step' => 0,
                'status' => 'SENT',
                'approver_id' => null,
                'comment' => 'Wysłano wniosek do akceptacji',
                'date' => '2025-03-10 08:05:00'
            ],
            [
                'leave_request_id' => 2,
                'step' => 1,
                'status' => 'APPROVED',
                'approver_id' => 2, // Andrzej Siwy (CTO)
                'comment' => 'Zatwierdzam urlop na żądanie',
                'date' => '2025-03-10 08:30:00'
            ],

            // Jan Kowalski - 3. Szkolenie Flutter
            [
                'leave_request_id' => 3,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => 'Utworzono wniosek urlopowy',
                'date' => '2025-04-15 10:00:00'
            ],
            [
                'leave_request_id' => 3,
                'step' => 0,
                'status' => 'SENT',
                'approver_id' => null,
                'comment' => 'Wysłano wniosek do akceptacji',
                'date' => '2025-04-15 10:15:00'
            ],

            // Anna Nowak - 4. Urlop zimowy
            [
                'leave_request_id' => 4,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => 'Utworzono wniosek urlopowy',
                'date' => '2024-12-15 09:30:00'
            ],
            [
                'leave_request_id' => 4,
                'step' => 0,
                'status' => 'SENT',
                'approver_id' => null,
                'comment' => 'Wysłano wniosek do akceptacji',
                'date' => '2024-12-15 09:35:00'
            ],
            [
                'leave_request_id' => 4,
                'step' => 1,
                'status' => 'APPROVED',
                'approver_id' => 6, // Maria Wiśniewska (HR Director)
                'comment' => 'Zatwierdzam urlop',
                'date' => '2024-12-16 11:20:00'
            ],
            [
                'leave_request_id' => 4,
                'step' => 2,
                'status' => 'APPROVED',
                'approver_id' => 1, // Marek Jankowski (CEO)
                'comment' => 'Zatwierdzam',
                'date' => '2024-12-18 14:30:00'
            ],

            // Anna Nowak - 5. Urlop na żądanie (14 luty)
            [
                'leave_request_id' => 5,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => 'Utworzono wniosek urlopowy',
                'date' => '2025-02-14 07:45:00'
            ],
            [
                'leave_request_id' => 5,
                'step' => 0,
                'status' => 'SENT',
                'approver_id' => null,
                'comment' => 'Wysłano wniosek do akceptacji',
                'date' => '2025-02-14 07:50:00'
            ],
            [
                'leave_request_id' => 5,
                'step' => 1,
                'status' => 'APPROVED',
                'approver_id' => 6, // Maria Wiśniewska (HR Director)
                'comment' => 'Zatwierdzam urlop na żądanie',
                'date' => '2025-02-14 08:15:00'
            ],
            [
                'leave_request_id' => 5,
                'step' => 2,
                'status' => 'APPROVED',
                'approver_id' => 1, // Marek Jankowski (CEO)
                'comment' => 'Zatwierdzam',
                'date' => '2025-02-14 09:15:00'
            ],

            // Anna Nowak - 6. Odrzucony wniosek na Grecję
            [
                'leave_request_id' => 6,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => 'Utworzono wniosek urlopowy',
                'date' => '2025-03-10 13:20:00'
            ],
            [
                'leave_request_id' => 6,
                'step' => 0,
                'status' => 'SENT',
                'approver_id' => null,
                'comment' => 'Wysłano wniosek do akceptacji',
                'date' => '2025-03-10 13:30:00'
            ],
            [
                'leave_request_id' => 6,
                'step' => 1,
                'status' => 'REJECTED',
                'approver_id' => 6, // Maria Wiśniewska (HR Director)
                'comment' => 'Niestety nie możemy zaakceptować wniosku ze względu na dużą liczbę nieobecności w dziale w tym terminie',
                'date' => '2025-03-13 09:45:00'
            ],

            // Anna Nowak - 7. Wakacje nad morzem (IN_PROGRESS)
            [
                'leave_request_id' => 7,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => 'Utworzono wniosek urlopowy',
                'date' => '2025-02-20 10:00:00'
            ],
            [
                'leave_request_id' => 7,
                'step' => 0,
                'status' => 'SENT',
                'approver_id' => null,
                'comment' => 'Wysłano wniosek do akceptacji',
                'date' => '2025-02-20 10:10:00'
            ],
            [
                'leave_request_id' => 7,
                'step' => 1,
                'status' => 'IN_PROGRESS',
                'approver_id' => 6, // Maria Wiśniewska (HR Director)
                'comment' => 'Wniosek jest w trakcie rozpatrywania',
                'date' => '2025-02-21 09:20:00'
            ],

            // Anna Nowak - 8. Szkolenie (SENT)
            [
                'leave_request_id' => 8,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => 'Utworzono wniosek urlopowy',
                'date' => '2025-02-25 11:30:00'
            ],
            [
                'leave_request_id' => 8,
                'step' => 0,
                'status' => 'SENT',
                'approver_id' => null,
                'comment' => 'Wysłano wniosek do akceptacji',
                'date' => '2025-02-25 11:40:00'
            ],

            // Anna Nowak - 9. Wizyta lekarska (DRAFT)
            [
                'leave_request_id' => 9,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => 'Utworzono wniosek urlopowy',
                'date' => '2025-02-28 15:00:00'
            ],

            // Piotr Wiśniewski - 10. Wyjazd na narty
            [
                'leave_request_id' => 10,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => 'Utworzono wniosek urlopowy',
                'date' => '2025-02-15 10:00:00'
            ],
            [
                'leave_request_id' => 10,
                'step' => 0,
                'status' => 'SENT',
                'approver_id' => null,
                'comment' => 'Wysłano wniosek do akceptacji',
                'date' => '2025-02-15 10:15:00'
            ],
            [
                'leave_request_id' => 10,
                'step' => 1,
                'status' => 'APPROVED',
                'approver_id' => 2, // Andrzej Siwy (CTO)
                'comment' => 'Zatwierdzam urlop',
                'date' => '2025-02-16 09:30:00'
            ],

            // Piotr Wiśniewski - 11. Szkolenie React
            [
                'leave_request_id' => 11,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => 'Utworzono wniosek urlopowy',
                'date' => '2025-05-20 11:00:00'
            ],
            [
                'leave_request_id' => 11,
                'step' => 0,
                'status' => 'SENT',
                'approver_id' => null,
                'comment' => 'Wysłano wniosek do akceptacji',
                'date' => '2025-05-20 11:05:00'
            ],
            [
                'leave_request_id' => 11,
                'step' => 1,
                'status' => 'REJECTED',
                'approver_id' => 2, // Andrzej Siwy (CTO)
                'comment' => 'Odrzucam z powodu zbyt dużej liczby nieobecności w zespole w tym terminie',
                'date' => '2025-05-21 14:30:00'
            ],

            // Piotr Wiśniewski - 12. Urlop na żądanie
            [
                'leave_request_id' => 12,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => 'Utworzono wniosek urlopowy',
                'date' => '2025-02-14 07:30:00'
            ],
            [
                'leave_request_id' => 12,
                'step' => 0,
                'status' => 'SENT',
                'approver_id' => null,
                'comment' => 'Wysłano wniosek do akceptacji',
                'date' => '2025-02-14 07:35:00'
            ],
            [
                'leave_request_id' => 12,
                'step' => 1,
                'status' => 'APPROVED',
                'approver_id' => 2, // Andrzej Siwy (CTO)
                'comment' => 'Zatwierdzam urlop na żądanie',
                'date' => '2025-02-14 08:15:00'
            ],

            // Tomasz Lewandowski - 13. Wakacje w Hiszpanii
            [
                'leave_request_id' => 13,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => 'Utworzono wniosek urlopowy',
                'date' => '2025-04-15 13:45:00'
            ],
            [
                'leave_request_id' => 13,
                'step' => 0,
                'status' => 'SENT',
                'approver_id' => null,
                'comment' => 'Wysłano wniosek do akceptacji',
                'date' => '2025-04-15 13:50:00'
            ],
            [
                'leave_request_id' => 13,
                'step' => 1,
                'status' => 'APPROVED',
                'approver_id' => 2, // Andrzej Siwy (CTO)
                'comment' => 'Zatwierdzam urlop',
                'date' => '2025-04-16 10:00:00'
            ],

            // Tomasz Lewandowski - 14. Konferencja UX/UI
            [
                'leave_request_id' => 14,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => 'Utworzono wniosek urlopowy',
                'date' => '2025-03-30 11:15:00'
            ],
            [
                'leave_request_id' => 14,
                'step' => 0,
                'status' => 'SENT',
                'approver_id' => null,
                'comment' => 'Wysłano wniosek do akceptacji',
                'date' => '2025-03-30 11:30:00'
            ],
            [
                'leave_request_id' => 14,
                'step' => 1,
                'status' => 'APPROVED',
                'approver_id' => 2, // Andrzej Siwy (CTO)
                'comment' => 'Zatwierdzam urlop szkoleniowy',
                'date' => '2025-03-31 09:15:00'
            ],

            // Tomasz Lewandowski - 15. Urlop na żądanie
            [
                'leave_request_id' => 15,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => 'Utworzono wniosek urlopowy',
                'date' => '2025-03-02 18:30:00'
            ],
            [
                'leave_request_id' => 15,
                'step' => 0,
                'status' => 'SENT',
                'approver_id' => null,
                'comment' => 'Wysłano wniosek do akceptacji',
                'date' => '2025-03-02 18:35:00'
            ],
            [
                'leave_request_id' => 15,
                'step' => 1,
                'status' => 'APPROVED',
                'approver_id' => 2, // Andrzej Siwy (CTO)
                'comment' => 'Zatwierdzam urlop na żądanie',
                'date' => '2025-03-03 08:05:00'
            ],

            // Karolina Dąbrowska - 16. Urlop we Włoszech
            [
                'leave_request_id' => 16,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => 'Utworzono wniosek urlopowy',
                'date' => '2025-06-20 11:45:00'
            ],
            [
                'leave_request_id' => 16,
                'step' => 0,
                'status' => 'SENT',
                'approver_id' => null,
                'comment' => 'Wysłano wniosek do akceptacji',
                'date' => '2025-06-20 12:00:00'
            ],
            [
                'leave_request_id' => 16,
                'step' => 1,
                'status' => 'IN_PROGRESS',
                'approver_id' => 2, // Andrzej Siwy (CTO)
                'comment' => 'Wniosek w trakcie rozpatrywania',
                'date' => '2025-06-21 09:20:00'
            ],

            // Karolina Dąbrowska - 17. Urlop na żądanie
            [
                'leave_request_id' => 17,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => 'Utworzono wniosek urlopowy',
                'date' => '2025-02-28 08:00:00'
            ],
            [
                'leave_request_id' => 17,
                'step' => 0,
                'status' => 'SENT',
                'approver_id' => null,
                'comment' => 'Wysłano wniosek do akceptacji',
                'date' => '2025-02-28 08:05:00'
            ],
            [
                'leave_request_id' => 17,
                'step' => 1,
                'status' => 'APPROVED',
                'approver_id' => 2, // Andrzej Siwy (CTO)
                'comment' => 'Zatwierdzam urlop na żądanie',
                'date' => '2025-02-28 08:30:00'
            ],

            // Karolina Dąbrowska - 18. Szkolenie cloud computing
            [
                'leave_request_id' => 18,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => 'Utworzono wniosek urlopowy',
                'date' => '2025-05-15 10:30:00'
            ],
            [
                'leave_request_id' => 18,
                'step' => 0,
                'status' => 'SENT',
                'approver_id' => null,
                'comment' => 'Wysłano wniosek do akceptacji',
                'date' => '2025-05-15 10:40:00'
            ],

            // Aleksandra Wojciechowska - 19. Wakacje rodzinne
            [
                'leave_request_id' => 19,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => 'Utworzono wniosek urlopowy',
                'date' => '2025-05-10 13:30:00'
            ],
            [
                'leave_request_id' => 19,
                'step' => 0,
                'status' => 'SENT',
                'approver_id' => null,
                'comment' => 'Wysłano wniosek do akceptacji',
                'date' => '2025-05-10 13:45:00'
            ],
            [
                'leave_request_id' => 19,
                'step' => 1,
                'status' => 'APPROVED',
                'approver_id' => 2, // Andrzej Siwy (CTO)
                'comment' => 'Zatwierdzam urlop',
                'date' => '2025-05-11 09:30:00'
            ],

            // Aleksandra Wojciechowska - 20. Ślub siostry
            [
                'leave_request_id' => 20,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => 'Utworzono wniosek urlopowy',
                'date' => '2025-05-10 09:45:00'
            ],
            [
                'leave_request_id' => 20,
                'step' => 0,
                'status' => 'SENT',
                'approver_id' => null,
                'comment' => 'Wysłano wniosek do akceptacji',
                'date' => '2025-05-10 10:00:00'
            ],
            [
                'leave_request_id' => 20,
                'step' => 1,
                'status' => 'IN_PROGRESS',
                'approver_id' => 2, // Andrzej Siwy (CTO)
                'comment' => 'Wniosek w trakcie rozpatrywania',
                'date' => '2025-05-11 11:15:00'
            ],

            // Natalia Kamińska - 21. Wakacje w górach
            [
                'leave_request_id' => 21,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => 'Utworzono wniosek urlopowy',
                'date' => '2025-07-01 10:00:00'
            ],
            [
                'leave_request_id' => 21,
                'step' => 0,
                'status' => 'SENT',
                'approver_id' => null,
                'comment' => 'Wysłano wniosek do akceptacji',
                'date' => '2025-07-01 10:15:00'
            ],
            [
                'leave_request_id' => 21,
                'step' => 1,
                'status' => 'REJECTED',
                'approver_id' => 2, // Andrzej Siwy (CTO)
                'comment' => 'Brak dostępnego zastępstwa - zastępująca osoba odrzuciła prośbę',
                'date' => '2025-07-02 11:30:00'
            ],

            // Natalia Kamińska - 22. Konferencja projektowa
            [
                'leave_request_id' => 22,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => 'Utworzono wniosek urlopowy',
                'date' => '2025-04-10 14:00:00'
            ],
            [
                'leave_request_id' => 22,
                'step' => 0,
                'status' => 'SENT',
                'approver_id' => null,
                'comment' => 'Wysłano wniosek do akceptacji',
                'date' => '2025-04-10 14:15:00'
            ],
            [
                'leave_request_id' => 22,
                'step' => 1,
                'status' => 'APPROVED',
                'approver_id' => 2, // Andrzej Siwy (CTO)
                'comment' => 'Zatwierdzam urlop szkoleniowy',
                'date' => '2025-04-11 10:30:00'
            ],

            // Adam Piotrowski - 23. Urlop w Chorwacji
            [
                'leave_request_id' => 23,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => 'Utworzono wniosek urlopowy',
                'date' => '2025-08-01 15:30:00'
            ],
            [
                'leave_request_id' => 23,
                'step' => 0,
                'status' => 'SENT',
                'approver_id' => null,
                'comment' => 'Wysłano wniosek do akceptacji',
                'date' => '2025-08-01 15:45:00'
            ],

            // Adam Piotrowski - 24. Opieka nad dzieckiem
            [
                'leave_request_id' => 24,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => 'Utworzono wniosek urlopowy',
                'date' => '2025-03-17 07:30:00'
            ],
            [
                'leave_request_id' => 24,
                'step' => 0,
                'status' => 'SENT',
                'approver_id' => null,
                'comment' => 'Wysłano wniosek do akceptacji',
                'date' => '2025-03-17 07:35:00'
            ],
            [
                'leave_request_id' => 24,
                'step' => 1,
                'status' => 'APPROVED',
                'approver_id' => 2, // Andrzej Siwy (CTO)
                'comment' => 'Zatwierdzam urlop opiekuńczy',
                'date' => '2025-03-17 08:15:00'
            ],

            // Łukasz Michalski - 25. Urlop w Grecji
            [
                'leave_request_id' => 25,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => 'Utworzono wniosek urlopowy',
                'date' => '2025-07-15 09:45:00'
            ],
            [
                'leave_request_id' => 25,
                'step' => 0,
                'status' => 'SENT',
                'approver_id' => null,
                'comment' => 'Wysłano wniosek do akceptacji',
                'date' => '2025-07-15 10:00:00'
            ],
            [
                'leave_request_id' => 25,
                'step' => 1,
                'status' => 'IN_PROGRESS',
                'approver_id' => 2, // Andrzej Siwy (CTO)
                'comment' => 'Wniosek w trakcie rozpatrywania',
                'date' => '2025-07-16 11:30:00'
            ],

            // Łukasz Michalski - 26. Szkolenie z cyberbezpieczeństwa
            [
                'leave_request_id' => 26,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => 'Utworzono wniosek urlopowy',
                'date' => '2025-04-20 13:15:00'
            ],
            [
                'leave_request_id' => 26,
                'step' => 0,
                'status' => 'SENT',
                'approver_id' => null,
                'comment' => 'Wysłano wniosek do akceptacji',
                'date' => '2025-04-20 13:30:00'
            ],
            [
                'leave_request_id' => 26,
                'step' => 1,
                'status' => 'APPROVED',
                'approver_id' => 2, // Andrzej Siwy (CTO)
                'comment' => 'Zatwierdzam urlop szkoleniowy',
                'date' => '2025-04-21 09:00:00'
            ],

            // Rafał Jankowski - 27. Urlop w Portugalii
            [
                'leave_request_id' => 27,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => 'Utworzono wniosek urlopowy',
                'date' => '2025-05-25 17:00:00'
            ],
            [
                'leave_request_id' => 27,
                'step' => 0,
                'status' => 'SENT',
                'approver_id' => null,
                'comment' => 'Wysłano wniosek do akceptacji',
                'date' => '2025-05-25 17:10:00'
            ],
            [
                'leave_request_id' => 27,
                'step' => 1,
                'status' => 'APPROVED',
                'approver_id' => 2, // Andrzej Siwy (CTO)
                'comment' => 'Zatwierdzam urlop',
                'date' => '2025-05-26 10:00:00'
            ],

            // Rafał Jankowski - 28. WWDC 2025
            [
                'leave_request_id' => 28,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => 'Utworzono wniosek urlopowy',
                'date' => '2025-02-15 11:30:00'
            ],
            [
                'leave_request_id' => 28,
                'step' => 0,
                'status' => 'SENT',
                'approver_id' => null,
                'comment' => 'Wysłano wniosek do akceptacji',
                'date' => '2025-02-15 11:45:00'
            ],
            [
                'leave_request_id' => 28,
                'step' => 1,
                'status' => 'APPROVED',
                'approver_id' => 2, // Andrzej Siwy (CTO)
                'comment' => 'Zatwierdzam urlop szkoleniowy',
                'date' => '2025-02-16 09:20:00'
            ],
            [
                'leave_request_id' => 28,
                'step' => 0,
                'status' => 'CANCELLED',
                'approver_id' => null,
                'comment' => 'Wniosek anulowany przez pracownika z powodu zmiany terminu konferencji',
                'date' => '2025-02-28 14:15:00'
            ],
            [
                'leave_request_id' => 29, // ID nowego wniosku
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => 'Utworzono wniosek urlopowy',
                'date' => '2025-05-15 10:30:00'
            ],
            [
                'leave_request_id' => 29,
                'step' => 0,
                'status' => 'SENT',
                'approver_id' => null,
                'comment' => 'Wysłano wniosek do akceptacji',
                'date' => '2025-05-15 10:40:00'
            ],
            [
                'leave_request_id' => 29,
                'step' => 1,
                'status' => 'IN_PROGRESS',
                'approver_id' => 4, // Anna Nowak (HR Specialist)
                'comment' => 'Wniosek w trakcie rozpatrywania',
                'date' => '2025-05-16 09:15:00'
            ],
        ];

        DB::table('approval_steps_histories')->insert($approvalStepsHistory);
    }
}
