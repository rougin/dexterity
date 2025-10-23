<?php

namespace Rougin\Dexterity\Fixture\Routes;

use Rougin\Dexterity\Route;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Tset extends Route
{
    /**
     * @var boolean
     */
    protected $valid = true;

    /**
     * @return self
     */
    public function setAsInvalid()
    {
        $this->valid = false;

        return $this;
    }

    /**
     * Checks if the specified item can be deleted.
     *
     * @param integer $id
     *
     * @return boolean
     */
    protected function isDeleteValid($id)
    {
        return $this->valid;
    }

    /**
     * Checks if the items are allowed to be returned.
     *
     * @param array<string, mixed> $params
     *
     * @return boolean
     */
    protected function isIndexValid($params)
    {
        return $this->valid;
    }

    /**
     * Checks if the specified item is allowed to be returned.
     *
     * @param integer              $id
     * @param array<string, mixed> $params
     *
     * @return boolean
     */
    protected function isShowValid($id, $params)
    {
        return $this->valid;
    }

    /**
     * Checks if it is allowed to create a new item.
     *
     * @param array<string, mixed> $parsed
     *
     * @return boolean
     */
    protected function isStoreValid($parsed)
    {
        return $this->valid;
    }

    /**
     * Checks if the specified item can be updated.
     *
     * @param integer              $id
     * @param array<string, mixed> $parsed
     *
     * @return boolean
     */
    protected function isUpdateValid($id, $parsed)
    {
        return $this->valid;
    }
}
