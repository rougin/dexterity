<?php

namespace Rougin\Dexterity\Fixture\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property string  $email
 * @property string  $name
 *
 * @method \Rougin\Dexterity\Fixture\Models\User create(array<string, mixed> $data)
 *
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class User extends Model
{
    use SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable =
    [
        'email',
        'name',
    ];

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @return array<string, mixed>
     */
    public function asRow()
    {
        $row = array('id' => $this->id);

        $row['name'] = $this->name;

        $row['email'] = $this->email;

        return $row;
    }
}
