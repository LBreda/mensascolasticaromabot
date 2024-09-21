<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Grado newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Grado newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Grado query()
 * @method static \Illuminate\Database\Eloquent\Builder|Grado whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Grado whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Grado whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Grado whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Grado extends Model
{
    protected $table = 'gradi';

    protected $guarded = ['id'];
}
