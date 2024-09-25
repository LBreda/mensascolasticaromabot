<?php

namespace App\Telegram\Commands;

use App\MensaComune\Client;
use App\Models\Municipio;
use App\Models\NotificationRequest;
use Carbon\Carbon;
use http\Client\Curl\User;
use Illuminate\Database\Eloquent\Collection;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class Domani extends Oggi
{
    protected string $name = 'domani';
    protected string $description = 'Ottiene il menu di domani';
    protected function menuDate(): Carbon
    {
        return now()->addDay();
    }
    protected string $emptyMessage = 'Non è presente alcun menu per domani.';
}
