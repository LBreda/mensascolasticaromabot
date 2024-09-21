<?php

namespace App\Telegram\Commands;

use App\MensaComune\Client;
use App\Models\Municipio;
use App\Models\NotificationRequest;
use http\Client\Curl\User;
use Illuminate\Database\Eloquent\Collection;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class Oggi extends Command
{
    protected string $name = 'oggi';
    protected string $description = 'Ottiene il menu di oggi';

    /**
     * Shows the menu to for today
     * @return void
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    public function handle(): void
    {
        // Sends the notifications
        $user = \App\Models\User::firstWhere(['telegram_id' => $this->getUpdate()->message->from->id]);

        $atLeastOneMessage = false;
        $user->notification_requests->each(function (NotificationRequest $nr) use ($user, &$atLeastOneMessage) {
            $menu = Client::getMenu($nr->municipio_id, $nr->grado_id);
            if ($menu) {
                \Telegram::sendMessage([
                    'chat_id' => $this->getUpdate()->message->chat->id,
                    'text'    => $menu,
                    'parse_mode' => 'HTML'
                ]);
                $atLeastOneMessage = true;
            }
        });
        if(!$atLeastOneMessage) {
            \Telegram::sendMessage([
                'chat_id' => $this->getUpdate()->message->chat->id,
                'text'    => 'Non è presente alcun menu per oggi.',
            ]);
        }
    }
}
