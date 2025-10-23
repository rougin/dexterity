<?php

namespace Rougin\Dexterity\Fixture\Depots;

use Rougin\Dexterity\Depots\EloquentDepot;
use Rougin\Dexterity\Fixture\Models\User;

/**
 * @method \Rougin\Dexterity\Fixture\Models\User find(integer $id)
 *
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class UserDepot extends EloquentDepot
{
    /**
     * @param \Rougin\Dexterity\Fixture\Models\User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * @param \Rougin\Dexterity\Fixture\Models\User $row
     *
     * @return array<string, mixed>
     */
    protected function parseRow($row)
    {
        $data = array('id' => $row->id);

        $data['name'] = $row->name;

        $data['email'] = $row->email;

        return $data;
    }
}
