<?php

namespace Rougin\Dexterity\Fixture\Depots;

use Rougin\Dexterity\Depot;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class TestDepot extends Depot
{
    /**
     * @param integer $id
     *
     * @return boolean
     */
    public function rowExists($id)
    {
        return true;
    }

    /**
     * @param integer $id
     *
     * @return mixed
     * @throws \UnexpectedValueException
     */
    protected function findRow($id)
    {
        return array();
    }

    /**
     * @param integer $page
     * @param integer $limit
     *
     * @return mixed[]
     */
    protected function getItems($page, $limit)
    {
        return array();
    }
}
