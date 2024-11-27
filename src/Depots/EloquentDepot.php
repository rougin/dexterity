<?php

namespace Rougin\Dexterity\Depots;

use Rougin\Dexterity\Depot;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class EloquentDepot extends Depot
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Creates a new item.
     *
     * @param array<string, mixed> $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($data)
    {
        /** @phpstan-ignore-next-line */
        return $this->model->create($data);
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
        /** @phpstan-ignore-next-line */
        return $this->model->update($id, $data);
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
        /** @var boolean */
        return $this->findRow($id)->delete();
    }

    /**
     * Returns the specified item.
     *
     * @param integer $id
     *
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \UnexpectedValueException
     */
    protected function findRow($id)
    {
        /** @phpstan-ignore-next-line */
        return $this->model->findOrFail($id);
    }

    /**
     * Returns the items with filters.
     *
     * @param integer $page
     * @param integer $limit
     *
     * @return \Illuminate\Database\Eloquent\Model[]
     */
    protected function getItems($page, $limit)
    {
        /** @phpstan-ignore-next-line */
        $model = $this->model->limit($limit);

        $offset = $this->getOffset($page, $limit);

        return $model->offset($offset)->get();
    }

    /**
     * Returns the total number of items.
     *
     * @return integer
     */
    protected function getTotal()
    {
        return $this->model->count();
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
        $model = $this->model;

        /** @phpstan-ignore-next-line */
        $model = $model->where('id', $id);

        return $model->exists();
    }
}
