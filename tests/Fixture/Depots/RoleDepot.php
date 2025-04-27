<?php

namespace Rougin\Dexterity\Fixture\Depots;

use Rougin\Dexterity\Depots\EloquentDepot;
use Rougin\Dexterity\Fixture\Models\Role;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class RoleDepot extends EloquentDepot
{
    /**
     * @param \Rougin\Dexterity\Fixture\Models\Role $role
     */
    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    /**
     * @param \Rougin\Dexterity\Fixture\Models\Role $row
     *
     * @return array<string, mixed>
     */
    protected function parseRow($row)
    {
        $data = array();

        $data['type'] = $row->type;

        $data['slug'] = $row->slug;

        $data['name'] = $row->name;

        return $data;
    }
}
