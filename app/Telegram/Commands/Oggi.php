<?php

namespace App\Telegram\Commands;

use App\MensaComune\Client;
use App\Models\NotificationRequest;
use Carbon\Carbon;
use Telegram\Bot\Commands\Command;

class Oggi extends Command
{
    protected string $name = 'oggi';
    protected string $description = 'Ottiene il menu di oggi';
    protected function menuDate(): Carbon
    {
        return now();
    }
    protected string $emptyMessage = 'Non è presente alcun menu per oggi.';

    /**
     * Shows the menu to for today
     * @return void
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    public function handle(): void
    {
        $user = \App\Models\User::firstWhere(['telegram_id' => $this->getUpdate()->message->from->id]);
        if(!$user) {
            $this->replyWithMessage(['text' => "La tua utenza non è presente. Usa il comando /start per iniziare a usare il bot."]);
            return;
        }

        // Sends the notifications
        $atLeastOneMessage = false;
        $user->notification_requests->each(function (NotificationRequest $nr) use (&$user, &$atLeastOneMessage) {
            $user = $user->refreshTelegramInfo();
            $menu = Client::getMenu($nr->municipio_id, $nr->grado_id, $this->menuDate());
            if ($menu) {
                \Telegram::sendMessage([
                    'chat_id' => $this->getUpdate()->message->chat->id,
                    'text'    => (($user->telegram_user_data['first_name'] ?? false) ? "Ciao {$user->telegram_user_data['first_name']}!\n\n" : "Ciao!\n\n") . $menu,
                    'parse_mode' => 'HTML'
                ]);
                $atLeastOneMessage = true;
            }
        });
        if(!$atLeastOneMessage) {
            \Telegram::sendMessage([
                'chat_id' => $this->getUpdate()->message->chat->id,
                'text'    => $this->emptyMessage,
            ]);
        }
    }
}
