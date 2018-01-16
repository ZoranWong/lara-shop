<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Cache
 *
 * @mixin \Eloquent
 * @property string $key
 * @property string $value
 * @property int $expiration
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cache whereExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cache whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cache whereValue($value)
 */
class Cache extends Model
{
    //
    protected $table = 'cache';

    protected $fillable = [
        'id',
        'key',
        'expiration'
    ];
}
