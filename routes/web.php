<?php

use App\Telegram\CallbackHandler;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Support\Facades\Route;

Route::withoutMiddleware([ValidateCsrfToken::class])->post('/tg/' . config('telegram.bots.MensaScolasticaRoma.token') . '/webhook', function () {
    $updates = Telegram::commandsHandler(true);

    if (!is_array($updates)) {
        $updates = [$updates];
    }
    foreach ($updates as $update) {
        if ($update->objectType() === 'callback_query') {
            CallbackHandler::handle($update);
        }
    }

    return 'ok';
});
