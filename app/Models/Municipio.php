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
 * @method static \Illuminate\Database\Eloquent\Builder|Municipio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Municipio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Municipio query()
 * @method static \Illuminate\Database\Eloquent\Builder|Municipio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Municipio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Municipio whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Municipio whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Municipio extends Model
{
    protected $table = 'municipi';

    protected $guarded = ['id'];
}
