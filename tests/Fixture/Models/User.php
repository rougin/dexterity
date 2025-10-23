<?php

namespace Rougin\Dexterity\Fixture\Models;

use Illuminate\Database\Eloquent\Model;

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
    /**
     * @var array<string, string>
     */
    protected $casts = array(

        'id' => 'integer',

    );

    /**
     * @var string[]
     */
    protected $fillable = array(

        'email',
        'name',

    );

    /**
     * @return array<string, mixed>
     */
    public function asRow()
    {
        // PHP 5.3 - '"id":1' returns '"id":"1"' instead, ---
        // even manually adding "id" to "$casts" property ---
        $row = array('id' => (int) $this->id);
        // --------------------------------------------------

        $row['name'] = $this->name;

        $row['email'] = $this->email;

        return $row;
    }
}
