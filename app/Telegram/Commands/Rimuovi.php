<?php

namespace App\Telegram\Commands;

use App\Models\Municipio;
use App\Models\NotificationRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class Rimuovi extends Command
{
    protected string $name = 'rimuovi';
    protected string $description = 'Rimuove una notifica';

    /**
     * Shows the menu to select the Municipio. The rest of the notification adding process
     * is handled via callbacks.
     * @return void
     */
    public function handle(): void
    {
        // Prepares a list of the current user notifications
        $user = User::firstWhere('telegram_id', $this->getUpdate()->message->from->id);
        $notification_requests = $user->notification_requests;

        if($notification_requests->count()) {
            $keyboard = $notification_requests->reduce(fn(Keyboard $keyboard, NotificationRequest $nr) => $keyboard->row([
                Keyboard::inlineButton([
                    'text'          => "{$nr->municipio->name} - {$nr->grado->name}",
                    'callback_data' => "remove_notification|{$nr->id}",
                ]),
            ]), Keyboard::make()->inline());

            // Sends the keyboard to the user
            \Telegram::sendMessage([
                'chat_id'      => $this->getUpdate()->message->chat->id,
                'text'         => 'Seleziona la notifica da rimuovere:',
                'reply_markup' => $keyboard,
            ]);
        } else {
            // Sends the keyboard to the user
            \Telegram::sendMessage([
                'chat_id'      => $this->getUpdate()->message->chat->id,
                'text'         => 'Non ci sono notifiche attive.',
            ]);
        }
    }
}
