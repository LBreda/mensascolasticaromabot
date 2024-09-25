<?php

namespace App\Telegram\Commands;

use App\Models\User;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class Stop extends Command
{
    protected string $name = 'stop';
    protected string $description = 'Ferma il bot';

    /**
     * Creates the user and greets them
     * @return void
     */
    public function handle(): void
    {
        $user = User::firstWhere(['telegram_id' => $this->getUpdate()->message->from->id]);

        $keyboard = Keyboard::make()->inline()->row([
            Keyboard::inlineButton([
                'text'          => 'Sì',
                'callback_data' => "stop|y",
            ]),
            Keyboard::inlineButton([
                'text'          => 'No',
                'callback_data' => "stop|n",
            ]),
        ]);
        \Telegram::sendMessage([
            'chat_id'      => $this->getUpdate()->message->chat->id,
            'text'         => 'Questo comando ferma i bot e cancella tutti i tuoi dati dalla memoria del bot. Vuoi proseguire?',
            'reply_markup' => $keyboard,
        ]);
    }
}
