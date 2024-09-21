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
    }
}
