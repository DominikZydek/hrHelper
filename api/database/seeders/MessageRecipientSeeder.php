<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Message;
use App\Models\User;
use App\Models\MessageRecipient;
use Carbon\Carbon;

class MessageRecipientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $messages = Message::all();

        if ($messages->isEmpty()) {
            $this->command->info('No messages found. Please run the message seeder first.');
            return;
        }

        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->info('No users found. Please run the user seeder first.');
            return;
        }

        $now = Carbon::now();

        // Przypisz odbiorców do każdej wiadomości
        foreach ($messages as $message) {
            // Pomiń autora wiadomości jako odbiorcę
            $potentialRecipients = $users->where('id', '!=', $message->author_id);

            // Wybierz od 5 do 15 odbiorców (lub wszystkich dostępnych, jeśli jest ich mniej)
            $recipientCount = min(rand(5, 15), $potentialRecipients->count());

            // Wybierz losowych odbiorców
            $selectedRecipients = $potentialRecipients->random($recipientCount);

            foreach ($selectedRecipients as $recipient) {
                // Określ, czy wiadomość została przeczytana
                $isPublished = $message->publication_date <= $now;

                $seen = false;
                $updatedAt = $message->publication_date;

                if ($isPublished) {
                    // Dla opublikowanych wiadomości, ustal prawdopodobieństwo przeczytania
                    // w zależności od priorytetu i czasu, jaki upłynął od publikacji
                    $daysSincePublished = $now->diffInDays($message->publication_date);
                    $probabilityBase = 0;

                    if ($message->priority == 3) { // Wysoki priorytet
                        $probabilityBase = 90; // 90% bazowego prawdopodobieństwa
                    } elseif ($message->priority == 2) { // Średni priorytet
                        $probabilityBase = 70; // 70% bazowego prawdopodobieństwa
                    } else { // Niski priorytet
                        $probabilityBase = 50; // 50% bazowego prawdopodobieństwa
                    }

                    // Zwiększ prawdopodobieństwo w zależności od czasu, jaki upłynął
                    $timeInfluence = min($daysSincePublished * 5, 40); // Maksymalnie dodaj 40%

                    $probability = min($probabilityBase + $timeInfluence, 100);

                    // Ustal, czy wiadomość została przeczytana
                    $seen = rand(1, 100) <= $probability;

                    if ($seen) {
                        // Jeśli przeczytano, ustaw datę aktualizacji na losową pomiędzy datą publikacji a teraz
                        $minHours = 1;
                        $maxHours = max(1, $now->diffInHours($message->publication_date));
                        $hoursAfterPublication = rand($minHours, $maxHours);

                        $updatedAt = Carbon::parse($message->publication_date)->addHours($hoursAfterPublication);
                    }
                }

                MessageRecipient::create([
                    'message_id' => $message->id,
                    'recipient_id' => $recipient->id,
                    'seen' => $seen,
                    'created_at' => $message->publication_date,
                    'updated_at' => $updatedAt,
                ]);
            }
        }
    }
}
