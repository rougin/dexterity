<?php

namespace Rougin\Dexterity;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Depot
{
    /**
     * Creates a new item.
     *
     * @param array<string, mixed> $data
     *
     * @return mixed
     */
    public function create($data)
    {
        // TODO: To be define by user

        return array();
    }

    /**
     * Deletes the specified item.
     *
     * @param integer $id
     *
     * @return boolean
     */
    public function delete($id)
    {
        if (! $this->rowExists($id))
        {
            return false;
        }

        return $this->deleteRow($id);
    }

    /**
     * Returns the specified item.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws \UnexpectedValueException
     */
    public function find($id)
    {
        return $this->parseRow($this->findRow($id));
    }

    /**
     * Returns an array of items.
     *
     * @param integer $page
     * @param integer $limit
     *
     * @return \Rougin\Dexterity\Result
     */
    public function get($page, $limit)
    {
        $result = $this->getItems($page, $limit);

        $items = array();

        foreach ($result as $item)
        {
            $items[] = $this->parseRow($item);
        }

        $total = $this->getTotal();

        return new Result($items, $total, $limit);
    }

    /**
     * Updates the specified item.
     *
     * @param integer              $id
     * @param array<string, mixed> $data
     *
     * @return boolean
     */
    public function update($id, $data)
    {
        // TODO: To be define by user

        return true;
    }

    /**
     * Deletes the specified item.
     *
     * @param integer $id
     *
     * @return boolean
     */
    protected function deleteRow($id)
    {
        // TODO: To be define by user

        return true;
    }

    /**
     * Returns the specified item.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws \UnexpectedValueException
     */
    protected function findRow($id)
    {
        // TODO: To be define by user

        return array();
    }

    /**
     * Returns the items with filters.
     *
     * @param integer $page
     * @param integer $limit
     *
     * @return mixed[]
     */
    protected function getItems($page, $limit)
    {
        // TODO: To be define by user

        return array();
    }

    /**
     * Returns the page offset.
     *
     * @param integer $page
     * @param integer $limit
     *
     * @return integer
     */
    protected function getOffset($page, $limit)
    {
        return $page === 1 ? 0 : ($page * $limit) - $limit;
    }

    /**
     * Returns the total number of items.
     *
     * @return integer
     */
    protected function getTotal()
    {
        // TODO: To be define by user

        return 0;
    }

    /**
     * Returns the parsed item.
     *
     * @param mixed $row
     *
     * @return mixed
     */
    protected function parseRow($row)
    {
        // TODO: To be define by user

        return $row;
    }

    /**
     * Checks if the specified item exists.
     *
     * @param integer $id
     *
     * @return boolean
     */
    protected function rowExists($id)
    {
        // TODO: To be define by user

        return true;
    }
}
