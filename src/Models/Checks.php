<?php

namespace Azuriom\Plugin\StatusPage\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int $position
 * @property bool $is_enabled
 * @property string $host
 * @property int $port
 * @property string $type
 */

class Checks extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'statuspage_servers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'position',
        'is_enabled',
        'host',
        'port',
        'type',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_enabled' => 'boolean',
    ];
}
