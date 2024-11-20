<?php

namespace Rougin\Dexterity\Depots;

use Rougin\Dexterity\Depot;

class EloquentDepot extends Depot
{
    protected $model;

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($id, $data)
    {
        return $this->model->update($id, $data);
    }

    protected function deleteRow($id)
    {
        return $this->findRow($id)->delete();
    }

    protected function findRow($id)
    {
        return $this->model->findOrFail($id);
    }

    protected function getItems($page, $limit)
    {
        $model = $this->model->limit($limit);

        $offset = $this->getOffset($page, $limit);

        return $model->offset($offset)->get();
    }

    protected function rowExists($id)
    {
        $model = $this->model;

        $model = $model->where('id', $id);

        return $model->exists();
    }
}
