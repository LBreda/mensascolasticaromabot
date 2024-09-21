<?php

namespace App\Telegram;

use App\Models\Grado;
use App\Models\Municipio;
use App\Models\NotificationRequest;
use App\Models\User;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\Update;

class CallbackHandler
{
    /**
     * Handles CallbackQuery updates
     * @param \Telegram\Bot\Objects\Update $update
     * @return void
     */
    public static function handle(Update $update)
    {
        // Saves the command and the payload
        list($command, $payload) = explode('|', $update->callbackQuery->data);

        \Log::debug($payload);

        // For each command calls the right method
        switch ($command) {
            case 'add_notification':
                self::add_notification($update, ...explode(',', $payload));
                break;
            case 'remove_notification':
                self::remove_notification($update, $payload);
                break;
            default:
                // Answers the query to avoid leaving the user without feedback
                \Telegram::answerCallbackQuery(['callback_query_id' => $update->callbackQuery->id]);
        }
    }

    /**
     * If the "grado" is NOT specified, this function shows a keyboard to select the grado.
     * If the "grado" is specified, this function saves a new notification request
     * @param \Telegram\Bot\Objects\Update $update
     * @param string|int $municipio
     * @param string|int|null $grado
     * @return void
     */
    private static function add_notification(Update $update, string|int $municipio, string|int $grado = null): void
    {
        if($grado === null) {
            $keyboard = Keyboard::make()->inline();
            Grado::all()->each(fn (Grado $g) => $keyboard->row([Keyboard::inlineButton([
                'text' => $g->name,
                'callback_data' => "{$update->callbackQuery->data},{$g->id}",
            ])]));

            \Telegram::answerCallbackQuery(['callback_query_id' => $update->callbackQuery->id]);
            \Telegram::editMessageText([
                'message_id' => $update->callbackQuery->message->messageId,
                'chat_id' => $update->callbackQuery->message->chat->id,
                'text' => 'Seleziona il grado:',
                'reply_markup' => $keyboard,
            ]);

            return;
        }

        NotificationRequest::updateOrCreate([
            'municipio_id' => $municipio,
            'grado_id' => $grado,
            'user_id' => User::firstWhere(['telegram_id' => $update->callbackQuery->from->id])->id,
        ]);

        \Telegram::answerCallbackQuery(['callback_query_id' => $update->callbackQuery->id]);
        $user = User::firstWhere(['telegram_id' => $update->callbackQuery->from->id]);
        \Telegram::editMessageText([
            'message_id' => $update->callbackQuery->message->messageId,
            'chat_id' => $update->callbackQuery->message->chat->id,
            'text' => 'Aggiunta una notifica per il ' . Municipio::find($municipio)->name . ', ' . Grado::find($grado)->name.
                      "\n\nLa notifica viene inviata alle {$user->preferred_notification_time}. Se preferisci un orario diverso, puoi cambiarlo con il comando /orario.".
                      "\n\nIn qualsiasi momento, con i comandi /oggi e /domani, puoi avere il menu del giorno e quello di domani.",
            'reply_markup' => null
        ]);
    }

    private static function remove_notification(Update $update, string|int $notification_request_id)
    {
        $user = User::firstWhere(['telegram_id' => $update->callbackQuery->from->id]);
        $notification_request = NotificationRequest::find((int) $notification_request_id);

        if($user and $notification_request and $notification_request->user_id === $user->id) {
            $notification_request->delete();

            \Telegram::answerCallbackQuery(['callback_query_id' => $update->callbackQuery->id]);
            \Telegram::editMessageText([
                'message_id' => $update->callbackQuery->message->messageId,
                'chat_id' => $update->callbackQuery->message->chat->id,
                'text' => "La notifica {$notification_request->municipio->name} - {$notification_request->grado->name} è stata rimossa.",
                'reply_markup' => null
            ]);
        } else {
            \Telegram::answerCallbackQuery(['callback_query_id' => $update->callbackQuery->id]);
            \Telegram::editMessageText([
                'message_id' => $update->callbackQuery->message->messageId,
                'chat_id' => $update->callbackQuery->message->chat->id,
                'text' => "La notifica non esiste e non è quindi possibile rimuoverla.",
                'reply_markup' => null
            ]);
        }
    }
}
