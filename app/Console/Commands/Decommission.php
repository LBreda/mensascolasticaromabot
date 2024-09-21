<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class Decommission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'msr:decommission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Decommissions this software';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Telegram::removeWebhook();
    }
}
