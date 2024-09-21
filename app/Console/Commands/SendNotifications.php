<?php

namespace App\Console\Commands;

use App\MensaComune\Client;
use App\Models\NotificationRequest;
use App\Models\User;
use Illuminate\Console\Command;

class SendNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'msr:send-notifications {telegram_id? : Telegram id of the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends notifications to an user. If the user is not specified, it sends to all the users for the current time.';

    /**
     * Execute the console command.
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    public function handle(): void
    {
        $telegram_id = $this->argument('telegram_id');

        if ($telegram_id) {
            $user = User::firstWhere('telegram_id', $telegram_id);
            if ($user) {
                $this->send($user);
            }
        } else {
            User::where('preferred_notification_time', now()->format('G:i'))
                ->orWhere('preferred_notification_time', now()->format('G:i:00'))
                ->orWhere('preferred_notification_time', now()->format('H:i'))
                ->orWhere('preferred_notification_time', now()->format('H:i:00'))
                ->each(function (User $user) {
                    $this->send($user);
                });
        }
    }

    /**
     * Sends the menu notifications to o user
     * @param User $user
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    private function send(User $user): void
    {
        $user->notification_requests->each(function (NotificationRequest $nr) use ($user) {
            $menu = Client::getMenu($nr->municipio_id, $nr->grado_id);
            if ($menu) {
                \Telegram::sendMessage([
                    'chat_id'    => $user->telegram_id,
                    'text'       => $menu,
                    'parse_mode' => 'HTML'
                ]);
            }
        });
    }
}
