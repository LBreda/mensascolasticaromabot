<?php

namespace App\Telegram\Commands;

use App\Models\Municipio;
use Illuminate\Database\Eloquent\Collection;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class Aggiungi extends Command
{
    protected string $name = 'aggiungi';
    protected string $description = 'Aggiunge una notifica';

    /**
     * Shows the menu to select the Municipio. The rest of the notification adding process
     * is handled via callbacks.
     * @return void
     */
    public function handle(): void
    {
        // Prepares a two-column keybord which lists all the Municipi
        // Each button will contain a callback with the add_notification command and the Municipio's id
        $keyboard = Municipio::all()->chunk(2)->reduce(fn(Keyboard $keyboard, Collection $m) => $keyboard->row([
            Keyboard::inlineButton([
                'text'          => $m->first()->name,
                'callback_data' => "add_notification|{$m->first()->id}",
            ]),
            Keyboard::inlineButton([
                'text'          => $m->last()->name,
                'callback_data' => "add_notification|{$m->last()->id}",
            ]),
        ]), Keyboard::make()->inline());

        // Sends the keyboard to the user
        \Telegram::sendMessage([
            'chat_id'      => $this->getUpdate()->message->chat->id,
            'text'         => 'Seleziona il municipio',
            'reply_markup' => $keyboard,
        ]);
    }
}
