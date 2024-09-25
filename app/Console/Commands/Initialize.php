<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class Initialize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'msr:initialize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initializes this software';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Telegram::setWebhook(['url' => config('telegram.bots.MensaScolasticaRoma.webhook_url')]);
        Telegram::setMyCommands([
            'commands' => [
                [
                    'command'     => 'oggi',
                    'description' => 'Mostra il menu di oggi',
                ],
                [
                    'command'     => 'domani',
                    'description' => 'Mostra il menu di domani',
                ],
                [
                    'command'     => 'aggiungi',
                    'description' => 'Aggiunge una nuova notifica',
                ],
                [
                    'command'     => 'rimuovi',
                    'description' => 'Rimuove una notifica',
                ],
                [
                    'command'     => 'orario',
                    'description' => 'Cambia l\'orario di notifica',
                ],
            ]
        ]);
    }
}
