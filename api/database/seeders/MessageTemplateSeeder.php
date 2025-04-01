<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class MessageTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $templates = [
            [
                'name' => 'Powiadomienie o spotkaniu zespołu',
                'subject' => 'Zaproszenie na cotygodniowe spotkanie zespołu',
                'content' => "Szanowni Państwo,\n\nZapraszam na cotygodniowe spotkanie zespołu, które odbędzie się [DATA] o godzinie [GODZINA] w sali konferencyjnej [SALA].\n\nPorządek obrad:\n1. Omówienie postępów w bieżących projektach\n2. Planowanie zadań na nadchodzący tydzień\n3. Sprawy różne\n\nProszę o przygotowanie krótkich raportów z postępów prac.\n\nZ poważaniem,\n[IMIĘ I NAZWISKO]",
                'priority' => 2,
                'require_confirmation' => true,
                'category_id' => 9, // Spotkania
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Ważna zmiana polityki firmy',
                'subject' => 'WAŻNE: Zmiana w polityce bezpieczeństwa informacji',
                'content' => "Szanowni Współpracownicy,\n\nInformujemy o wprowadzeniu istotnych zmian w polityce bezpieczeństwa informacji firmy, które wchodzą w życie z dniem [DATA].\n\nKluczowe zmiany:\n- Obowiązkowe dwustopniowe uwierzytelnianie do wszystkich systemów firmowych\n- Nowe procedury zgłaszania incydentów bezpieczeństwa\n- Zaktualizowane wytyczne dotyczące przechowywania danych osobowych\n\nSzczegółowe informacje można znaleźć w załączonej dokumentacji. Prosimy o zapoznanie się z nowymi procedurami i bezwzględne ich przestrzeganie.\n\nW razie pytań prosimy o kontakt z Działem IT.\n\nDział Bezpieczeństwa Informacji",
                'priority' => 3,
                'require_confirmation' => true,
                'category_id' => 3, // Ważne
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Newsletter miesięczny',
                'subject' => 'Newsletter firmowy - [MIESIĄC] [ROK]',
                'content' => "Drodzy Pracownicy,\n\nPrzedstawiamy comiesięczny newsletter z najważniejszymi informacjami z życia firmy.\n\n**Osiągnięcia miesiąca:**\n- [OSIĄGNIĘCIE 1]\n- [OSIĄGNIĘCIE 2]\n\n**Ważne wydarzenia:**\n- [WYDARZENIE 1] - [DATA]\n- [WYDARZENIE 2] - [DATA]\n\n**Nadchodzące święta i dni wolne:**\n- [ŚWIĘTO/DZIEŃ WOLNY] - [DATA]\n\n**Jubileusze pracowników:**\n- [IMIĘ NAZWISKO] - [LICZBA] lat w firmie\n\nŻyczymy wszystkim owocnej pracy!\n\nDział HR",
                'priority' => 1,
                'require_confirmation' => false,
                'category_id' => 8, // Newsletter
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Awaria systemu IT',
                'subject' => 'PILNE: Awaria systemu [NAZWA SYSTEMU]',
                'content' => "Szanowni Państwo,\n\nInformujemy o wystąpieniu awarii w systemie [NAZWA SYSTEMU], która może wpływać na Państwa pracę.\n\n**Opis problemu:**\n[OPIS PROBLEMU]\n\n**Przewidywany czas naprawy:**\n[CZAS NAPRAWY]\n\n**Procedura awaryjna:**\n[OPIS PROCEDURY AWARYJNEJ]\n\nNa bieżąco będziemy informować o postępach w rozwiązywaniu problemu.\n\nPrzepraszamy za utrudnienia.\n\nDział IT",
                'priority' => 3,
                'require_confirmation' => true,
                'category_id' => 5, // IT
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Ogłoszenie o awansie',
                'subject' => 'Ogłoszenie: Awans w strukturach firmy',
                'content' => "Szanowni Współpracownicy,\n\nZ przyjemnością informujemy, że z dniem [DATA] [IMIĘ I NAZWISKO] obejmuje stanowisko [NAZWA STANOWISKA] w [NAZWA DZIAŁU].\n\n[IMIĘ] posiada [LICZBA] lat doświadczenia w branży i od [LICZBA] lat jest związany/a z naszą firmą. Jesteśmy przekonani, że dzięki swojemu doświadczeniu i umiejętnościom doskonale sprawdzi się w nowej roli.\n\nProsimy o wsparcie [IMIĘ] w nowych obowiązkach i gratulujemy awansu!\n\nZ poważaniem,\nZarząd",
                'priority' => 2,
                'require_confirmation' => false,
                'category_id' => 1, // Ogłoszenia
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Zaproszenie na szkolenie',
                'subject' => 'Zaproszenie na szkolenie: [TEMAT SZKOLENIA]',
                'content' => "Szanowni Państwo,\n\nZ przyjemnością zapraszamy na szkolenie dotyczące [TEMAT SZKOLENIA], które odbędzie się w dniu [DATA] w godzinach [GODZINA ROZPOCZĘCIA] - [GODZINA ZAKOŃCZENIA] w [MIEJSCE].\n\n**Program szkolenia:**\n1. [MODUŁ 1]\n2. [MODUŁ 2]\n3. [MODUŁ 3]\n\n**Prowadzący:**\n[IMIĘ I NAZWISKO PROWADZĄCEGO]\n\nUdział w szkoleniu jest [OBOWIĄZKOWY/DOBROWOLNY]. Prosimy o potwierdzenie obecności do dnia [DATA POTWIERDZENIA].\n\nDział Rozwoju i Szkoleń",
                'priority' => 2,
                'require_confirmation' => true,
                'category_id' => 10, // Szkolenia
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Informacja o nowym projekcie',
                'subject' => 'Informacja o rozpoczęciu projektu [NAZWA PROJEKTU]',
                'content' => "Drodzy Współpracownicy,\n\nZ przyjemnością informujemy o rozpoczęciu nowego projektu [NAZWA PROJEKTU] z dniem [DATA ROZPOCZĘCIA].\n\n**Cel projektu:**\n[OPIS CELU]\n\n**Harmonogram:**\n- Faza 1: [OPIS] - termin do [DATA]\n- Faza 2: [OPIS] - termin do [DATA]\n- Faza 3: [OPIS] - termin do [DATA]\n\n**Zespół projektowy:**\n- Kierownik projektu: [IMIĘ I NAZWISKO]\n- [ROLA]: [IMIĘ I NAZWISKO]\n- [ROLA]: [IMIĘ I NAZWISKO]\n\nW razie pytań prosimy o kontakt z kierownikiem projektu.\n\nZ poważaniem,\n[IMIĘ I NAZWISKO]\n[STANOWISKO]",
                'priority' => 2,
                'require_confirmation' => false,
                'category_id' => 2, // Informacje
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Aktualizacja procedur administracyjnych',
                'subject' => 'Aktualizacja procedur administracyjnych od [DATA]',
                'content' => "Szanowni Państwo,\n\nInformujemy o wprowadzeniu zmian w procedurach administracyjnych, które wchodzą w życie z dniem [DATA].\n\n**Zmiany obejmują:**\n1. [OPIS ZMIANY 1]\n2. [OPIS ZMIANY 2]\n3. [OPIS ZMIANY 3]\n\nNowe procedury są dostępne w intranecie firmy w zakładce [NAZWA ZAKŁADKI].\n\nW razie pytań lub wątpliwości prosimy o kontakt z Działem Administracji.\n\nZ poważaniem,\nDział Administracji",
                'priority' => 2,
                'require_confirmation' => true,
                'category_id' => 6, // Administracja
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Ważna informacja HR',
                'subject' => 'WAŻNE: Zmiany w systemie świadczeń pracowniczych',
                'content' => "Szanowni Pracownicy,\n\nPragniemy poinformować o wprowadzeniu zmian w systemie świadczeń pracowniczych od [DATA].\n\n**Najważniejsze zmiany:**\n- [OPIS ZMIANY 1]\n- [OPIS ZMIANY 2]\n- [OPIS ZMIANY 3]\n\nSzczegółowe informacje na temat nowych rozwiązań zostały zamieszczone w intranecie w sekcji Kadry i Płace.\n\nZachęcamy do zapoznania się z nowymi możliwościami oraz terminami ich wdrożenia.\n\nW razie pytań prosimy o kontakt z Działem HR pod adresem: [ADRES EMAIL] lub telefonicznie: [NUMER TELEFONU].\n\nZ poważaniem,\nDział HR",
                'priority' => 2,
                'require_confirmation' => true,
                'category_id' => 4, // HR
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Kampania marketingowa',
                'subject' => 'Informacja o nowej kampanii marketingowej [NAZWA KAMPANII]',
                'content' => "Drodzy Współpracownicy,\n\nZ przyjemnością informujemy o rozpoczęciu nowej kampanii marketingowej [NAZWA KAMPANII], która rusza [DATA ROZPOCZĘCIA].\n\n**Cele kampanii:**\n- [CEL 1]\n- [CEL 2]\n- [CEL 3]\n\n**Główne przekazy:**\n- [PRZEKAZ 1]\n- [PRZEKAZ 2]\n\n**Kanały komunikacji:**\n- [KANAŁ 1]\n- [KANAŁ 2]\n- [KANAŁ 3]\n\nWszystkie materiały promocyjne są dostępne w folderze [NAZWA FOLDERU] na dysku wspólnym.\n\nProsimy o wsparcie kampanii we własnych kanałach komunikacji.\n\nW razie pytań prosimy o kontakt z [IMIĘ I NAZWISKO], koordynatorem kampanii.\n\nZ poważaniem,\nDział Marketingu",
                'priority' => 2,
                'require_confirmation' => false,
                'category_id' => 7, // Marketing
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('message_templates')->insert($templates);
    }
}
