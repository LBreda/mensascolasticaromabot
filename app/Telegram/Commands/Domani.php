<?php

namespace App\Telegram\Commands;

use App\MensaComune\Client;
use App\Models\Municipio;
use App\Models\NotificationRequest;
use http\Client\Curl\User;
use Illuminate\Database\Eloquent\Collection;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class Domani extends Command
{
    protected string $name = 'domani';
    protected string $description = 'Ottiene il menu di domani';

    /**
     * Shows the menu to for today
     * @return void
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    public function handle(): void
    {
        // Sends the notifications
        $user = \App\Models\User::firstWhere(['telegram_id' => $this->getUpdate()->message->from->id]);

        $user->notification_requests->each(function (NotificationRequest $nr) use ($user) {
            \Telegram::sendMessage([
                'chat_id' => $this->getUpdate()->message->chat->id,
                'text'    => Client::getMenu($nr->municipio_id, $nr->grado_id, now()->addDay()),
                'parse_mode' => 'HTML'
            ]);
        });
    }
}
