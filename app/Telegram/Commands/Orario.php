<?php

namespace App\Telegram\Commands;

use App\Models\User;
use Telegram\Bot\Commands\Command;

class Orario extends Command
{
    protected string $name = 'orario';
    protected string $pattern = '{orario: ([01][01]?[0-9]|2[0-3]|[1-9]):[0-5][0-9]}';
    protected string $description = "Modifica l'orario di notifica";

    /**
     * Creates the user and greets them
     * @return void
     */
    public function handle(): void
    {
        $user = User::firstWhere('telegram_id', $this->getUpdate()->message->from->id);
        $orario = $this->argument('orario');

        if(!$orario) {
            $this->replyWithMessage([
                'text' => "Per impostare l'orario digita `/orario` seguito dall'orario che vuoi. Ad esempio: `/orario 23:30`.",
                'parse_mode' => 'markdown',
            ]);
            return;
        }

        $user->update(['preferred_notification_time' => $orario]);

        $this->replyWithMessage([
            'text' => "Il nuovo orario di notifica è: {$orario}",
        ]);
    }
}
