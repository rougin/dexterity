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
     * @var \Rougin\Dexterity\Filter|null
     */
    protected $filter = null;

    /**
     * Creates a new item.
     *
     * @param array<string, mixed> $data
     *
     * @return mixed
     */
    public function create($data)
    {
        $text = 'The "[METHOD]" method must be overwriten in the concrete class.';

        throw new \LogicException(str_replace('[METHOD]', __FUNCTION__, $text));
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
        return $this->rowExists($id) ? $this->deleteRow($id) : false;
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
        return $this->findRow($id);
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
     * Returns the total number of items.
     *
     * @return integer
     */
    public function getTotal()
    {
        $text = 'The "[METHOD]" method must be overwriten in the concrete class.';

        throw new \LogicException(str_replace('[METHOD]', __FUNCTION__, $text));
    }

    /**
     * Checks if the specified item exists.
     *
     * @param integer $id
     *
     * @return boolean
     */
    public function rowExists($id)
    {
        $text = 'The "[METHOD]" method must be overwriten in the concrete class.';

        throw new \LogicException(str_replace('[METHOD]', __FUNCTION__, $text));
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
        $text = 'The "[METHOD]" method must be overwriten in the concrete class.';

        throw new \LogicException(str_replace('[METHOD]', __FUNCTION__, $text));
    }

    /**
     * @param \Rougin\Dexterity\Filter $filter
     *
     * @return self
     */
    public function withFilter(Filter $filter)
    {
        $this->filter = $filter;

        return $this;
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
        $text = 'The "[METHOD]" method must be overwriten in the concrete class.';

        throw new \LogicException(str_replace('[METHOD]', __FUNCTION__, $text));
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
        $text = 'The "[METHOD]" method must be overwriten in the concrete class.';

        throw new \LogicException(str_replace('[METHOD]', __FUNCTION__, $text));
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
        $text = 'The "[METHOD]" method must be overwriten in the concrete class.';

        throw new \LogicException(str_replace('[METHOD]', __FUNCTION__, $text));
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
     * Returns the parsed item.
     *
     * @param mixed $row
     *
     * @return mixed
     */
    protected function parseRow($row)
    {
        return $row;
    }
}
