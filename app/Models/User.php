<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 *
 *
 * @property int $id
 * @property array $telegram_user_data
 * @property string $telegram_id
 * @property string $preferred_notification_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePreferredNotificationTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTelegramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTelegramUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NotificationRequest> $notification_requests
 * @property-read int|null $notification_requests_count
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
    ];

    protected function casts(): array
    {
        return [
            'preferred_notification_time' => 'datetime:H:i',
            'telegram_user_data' => 'array',
        ];
    }

    public function notification_requests(): HasMany
    {
        return $this->hasMany(NotificationRequest::class);
    }

    /**
     * Refreshes Telegram user info
     */
    public function refreshTelegramInfo(): User
    {
        // Gets fresh info for the users
        $userInfo = \Telegram::getChat(['chat_id' => $this->telegram_id])->toArray();

        // Computes the new info array and saves it if different
        $currentTelegramUserData = count($this->telegram_user_data) ? $this->telegram_user_data : [
            "id"            => null,
            "is_bot"        => null,
            "first_name"    => null,
            "last_name"     => null,
            "username"      => null,
            "language_code" => null,
            "is_premium"    => null,
        ];
        $newTelegramUserData = array_merge($currentTelegramUserData, array_intersect_key($userInfo, $currentTelegramUserData));

        if (json_encode($newTelegramUserData) != json_encode($currentTelegramUserData)) {
            $this->update(['telegram_user_data' => $newTelegramUserData]);
        }

        return $this;
    }
}
