<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Message;
use App\Models\User;
use App\Models\MessageCategory;
use Carbon\Carbon;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->info('No users found. Please run the user seeder first.');
            return;
        }

        $categories = MessageCategory::all();

        if ($categories->isEmpty()) {
            $this->command->info('No message categories found. Please run the message category seeder first.');
            return;
        }

        // Przykładowe treści wiadomości
        $messages = [
            [
                'subject' => 'Zapowiedź nowego systemu komunikacji wewnętrznej',
                'content' => 'Szanowni Pracownicy,

Z przyjemnością informujemy, że od przyszłego miesiąca wprowadzamy nowy system komunikacji wewnętrznej, który usprawni przepływ informacji w naszej firmie. System ten umożliwi łatwiejsze zarządzanie wiadomościami oraz śledzenie odpowiedzi.

Szkolenia z nowego systemu odbędą się w dniach 15-20 kwietnia. Szczegółowe informacje zostaną przesłane w osobnej wiadomości.

Z poważaniem,
Dział IT',
                'priority' => 2,
                'category_id' => $this->getCategoryIdByName($categories, 'IT'),
                'require_confirmation' => true,
                'days_offset' => 5,
                'days_valid' => 60
            ],
            [
                'subject' => 'Informacja o zmianie godzin pracy biura',
                'content' => 'Informujemy, że od dnia 1 kwietnia 2025 r. biuro będzie czynne w godzinach 8:00-16:00 (zamiast dotychczasowych 9:00-17:00).

Zmiana ta ma na celu lepsze dostosowanie godzin pracy do potrzeb naszych klientów.

Dział Administracji',
                'priority' => 3,
                'category_id' => $this->getCategoryIdByName($categories, 'Administracja'),
                'require_confirmation' => true,
                'days_offset' => -3,
                'days_valid' => 30
            ],
            [
                'subject' => 'Newsletter firmowy - Marzec 2025',
                'content' => 'Szanowni Państwo,

W marcowym wydaniu naszego newslettera:
- Podsumowanie wyników finansowych za I kwartał
- Nowe projekty rozpoczęte w marcu
- Jubileusze pracowników
- Nadchodzące wydarzenia firmowe

Miłej lektury!
Zespół HR',
                'priority' => 1,
                'category_id' => $this->getCategoryIdByName($categories, 'Newsletter'),
                'require_confirmation' => false,
                'days_offset' => -10,
                'days_valid' => 45
            ],
            [
                'subject' => 'Zaproszenie na piknik firmowy',
                'content' => 'Szanowni Pracownicy,

Z przyjemnością zapraszamy wszystkich pracowników wraz z rodzinami na coroczny piknik firmowy, który odbędzie się 15 czerwca 2025 r. w Parku Miejskim.

W programie:
- Gry i zabawy dla dzieci
- Zawody sportowe
- Grill i poczęstunek
- Konkurs z nagrodami

Prosimy o potwierdzenie obecności do 31 maja.

Dział HR',
                'priority' => 2,
                'category_id' => $this->getCategoryIdByName($categories, 'HR'),
                'require_confirmation' => true,
                'days_offset' => 15,
                'days_valid' => 90
            ],
            [
                'subject' => 'Aktualizacja polityki prywatności',
                'content' => 'Informujemy, że z dniem 1 maja 2025 wchodzi w życie zaktualizowana Polityka Prywatności naszej firmy.

Główne zmiany dotyczą:
1. Sposobu przetwarzania danych osobowych
2. Okresu przechowywania danych
3. Praw pracowników dotyczących dostępu do danych

Pełna treść polityki dostępna jest w intranecie firmy.

Dział Prawny',
                'priority' => 3,
                'category_id' => $this->getCategoryIdByName($categories, 'Ważne'),
                'require_confirmation' => true,
                'days_offset' => 7,
                'days_valid' => 120
            ],
            [
                'subject' => 'Harmonogram szkoleń BHP',
                'content' => 'Szanowni Państwo,

Przypominamy o obowiązkowych szkoleniach BHP, które odbędą się w następujących terminach:

1. Dział IT: 10 kwietnia, godz. 10:00, sala A
2. Dział Marketingu: 11 kwietnia, godz. 10:00, sala A
3. Dział HR: 12 kwietnia, godz. 10:00, sala A
4. Dział Finansów: 13 kwietnia, godz. 10:00, sala A

Obecność obowiązkowa.

Dział BHP',
                'priority' => 2,
                'category_id' => $this->getCategoryIdByName($categories, 'Szkolenia'),
                'require_confirmation' => true,
                'days_offset' => 0,
                'days_valid' => 30
            ],
            [
                'subject' => 'Przerwa techniczna w działaniu systemu',
                'content' => 'Informujemy, że w dniu 5 kwietnia w godzinach 20:00-22:00 nastąpi przerwa techniczna w działaniu systemów informatycznych firmy w związku z planowanymi pracami konserwacyjnymi.

W tym czasie dostęp do większości systemów firmowych będzie niemożliwy.

Przepraszamy za wszelkie niedogodności.
Zespół IT',
                'priority' => 2,
                'category_id' => $this->getCategoryIdByName($categories, 'IT'),
                'require_confirmation' => false,
                'days_offset' => -1,
                'days_valid' => 10
            ],
            [
                'subject' => 'Nowa polityka parkingowa',
                'content' => 'Szanowni Pracownicy,

Od 1 maja 2025 wprowadzamy nową politykę parkingową na terenie firmy. Każdy pracownik otrzyma przypisane miejsce parkingowe.

Przydział miejsc parkingowych zostanie rozesłany w osobnej wiadomości do 15 kwietnia.

Z poważaniem,
Administracja Budynku',
                'priority' => 2,
                'category_id' => $this->getCategoryIdByName($categories, 'Administracja'),
                'require_confirmation' => false,
                'days_offset' => 10,
                'days_valid' => 45
            ],
            [
                'subject' => 'Awaria klimatyzacji - informacja',
                'content' => 'Informujemy, że w dniu dzisiejszym wystąpiła awaria systemu klimatyzacji w budynku A.

Trwają prace naprawcze. Przewidywany czas usunięcia usterki to 24 godziny.

Przepraszamy za niedogodności.
Administracja',
                'priority' => 3,
                'category_id' => $this->getCategoryIdByName($categories, 'Informacje'),
                'require_confirmation' => false,
                'days_offset' => -2,
                'days_valid' => 7
            ],
            [
                'subject' => 'Nowy klient - informacja prasowa',
                'content' => 'Szanowni Pracownicy,

Z przyjemnością informujemy, że nasza firma nawiązała współpracę z firmą XYZ, liderem branży technologicznej.

W załączeniu przesyłamy informację prasową, która zostanie opublikowana jutro.

Prosimy o nieudostępnianie tych informacji do czasu oficjalnej publikacji.

Dział Marketingu',
                'priority' => 2,
                'category_id' => $this->getCategoryIdByName($categories, 'Marketing'),
                'require_confirmation' => true,
                'days_offset' => -5,
                'days_valid' => 20
            ],
        ];

        $now = Carbon::now();

        foreach ($messages as $messageData) {
            // Losowy autor z listy użytkowników
            $author = $users->random();

            // Daty publikacji, od i do
            $publicationDate = $now->copy()->addDays($messageData['days_offset']);
            $dateFrom = $publicationDate->copy()->subDays(1);
            $dateTo = $publicationDate->copy()->addDays($messageData['days_valid']);

            Message::create([
                'author_id' => $author->id,
                'subject' => $messageData['subject'],
                'message_category_id' => $messageData['category_id'],
                'content' => $messageData['content'],
                'priority' => $messageData['priority'],
                'publication_date' => $publicationDate,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'require_confirmation' => $messageData['require_confirmation'],
            ]);
        }
    }

    /**
     * Pomocnicza funkcja do znalezienia ID kategorii po nazwie
     */
    private function getCategoryIdByName($categories, $name)
    {
        foreach ($categories as $category) {
            if ($category->name === $name) {
                return $category->id;
            }
        }

        // Domyślnie zwracamy pierwszą kategorię, jeśli nie znaleziono dopasowania
        return $categories->first()->id;
    }
}
