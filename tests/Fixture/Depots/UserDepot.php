<?php

namespace Rougin\Dexterity\Fixture\Depots;

use Rougin\Dexterity\Depots\EloquentDepot;
use Rougin\Dexterity\Fixture\Models\User;

/**
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
}
