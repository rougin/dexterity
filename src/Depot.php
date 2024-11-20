<?php

namespace Rougin\Dexterity;

class Depot
{
    public function create($data)
    {
        // TODO: To be define by user

        return array();
    }

    public function delete($id)
    {
        if (! $this->rowExists($id))
        {
            return false;
        }

        return $this->deleteRow($id);
    }

    public function find($id)
    {
        return $this->parseRow($this->findRow($id));
    }

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

    public function update($id, $data)
    {
        // TODO: To be define by user

        return array();
    }

    protected function deleteRow($id)
    {
        // TODO: To be define by user

        return true;
    }

    protected function findRow($id)
    {
        // TODO: To be define by user

        return array();
    }

    protected function getItems($page, $limit)
    {
        // TODO: To be define by user

        return array();
    }

    protected function getOffset($page, $limit)
    {
        return $page === 1 ? 0 : ($page * $limit) - $limit;
    }

    protected function getTotal()
    {
        // TODO: To be define by user

        return 0;
    }

    protected function parseRow($row)
    {
        return $row;
    }

    protected function rowExists($id)
    {
        // TODO: To be define by user

        return true;
    }
}
