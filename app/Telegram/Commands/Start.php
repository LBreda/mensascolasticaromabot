<?php

namespace App\Telegram\Commands;

use App\Models\User;
use Telegram\Bot\Commands\Command;

class Start extends Command
{
    protected string $name = 'start';
    protected string $description = 'Avvia il bot';

    /**
     * Creates the user and greets them
     * @return void
     */
    public function handle(): void
    {
        User::updateOrCreate([
            'telegram_id' => $this->getUpdate()->message->from->id,
        ],
        [
            'telegram_id' => $this->getUpdate()->message->from->id,
            'telegram_user_data' => $this->getUpdate()->message->from->toArray(),
            'preferred_notification_time' => '7:00',
        ]);
        $this->replyWithMessage([
            'text' => <<<EOF
                         Ciao! Questo bot è in grado di mandarti ogni giorno il menu della mensa scolastica del comune di Roma per i tuoi figli.

                         Usa il comando /aggiungi per aggiungere una notifica.

                         Il bot non è in alcun modo associato con il Comune di Roma.
                         EOF,

        ]);
    }
}
