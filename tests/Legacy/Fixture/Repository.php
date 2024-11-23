<?php

namespace Rougin\Dexterity\Legacy\Fixture;

use Rougin\Dexterity\Legacy\Repository\RepositoryInterface;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Repository implements RepositoryInterface
{
    protected $names = array('Dex', 'Ter', 'Ity');

    /**
     * Stores a newly created resource in storage.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function create($data)
    {
        return new Terminator($data['id'], $data['name']);
    }

    /**
     * Deletes the specified resource from storage.
     *
     * @param array|integer $id
     *
     * @return boolean
     */
    public function delete($id)
    {
        return true;
    }

    /**
     * Finds the specified resource from storage.
     *
     * @param array|integer $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return new Terminator($id, $this->names[$id - 1]);
    }

    /**
     * Paginates the specified page number and items per page.
     *
     * @param integer $page
     * @param integer $limit
     *
     * @return array
     */
    public function paginate($page, $limit)
    {
        $classes = array();

        foreach (array(1, 2, 3, 4, 5) as $id)
        {
            $new = (int) ($id + $limit);

            $classes[] = new Terminator($new);
        }

        return $classes;
    }

    /**
     * Updates the specified resource in storage.
     *
     * @param array|integer $id
     * @param array         $data
     *
     * @return boolean
     */
    public function update($id, $data)
    {
        return true;
    }
}
