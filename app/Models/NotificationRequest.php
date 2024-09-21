<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $municipio_id
 * @property int $grado_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationRequest whereGradoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationRequest whereMunicipioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationRequest whereUserId($value)
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Grado $grado
 * @property-read \App\Models\Municipio $municipio
 * @mixin \Eloquent
 */
class NotificationRequest extends Model
{
    protected $table = 'notification_requests';

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class);
    }

    public function grado(): BelongsTo
    {
        return $this->belongsTo(Grado::class);
    }
}
