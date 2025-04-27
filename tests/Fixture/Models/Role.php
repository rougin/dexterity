<?php

namespace Rougin\Dexterity\Fixture\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $type
 * @property string  $slug
 * @property string  $name
 *
 * @method \Rougin\Dexterity\Fixture\Models\Role create(array<string, mixed> $data)
 *
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Role extends Model
{
    use SoftDeletes;

    const TYPE_ADMIN = 0;

    const TYPE_USER = 1;

    /**
     * @var array<string, string>
     */
    protected $casts =
    [
        'type' => 'integer',
    ];

    /**
     * @var string[]
     */
    protected $fillable =
    [
        'name',
        'slug',
        'type',
    ];

    /**
     * @var string
     */
    protected $table = 'roles';
}
