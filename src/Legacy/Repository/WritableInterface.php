<?php

namespace Rougin\Dexterity\Legacy\Repository;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
interface WritableInterface
{
    /**
     * Stores a newly created resource in storage.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function create($data);

    /**
     * Deletes the specified resource from storage.
     *
     * @param array|integer $id
     *
     * @return boolean
     */
    public function delete($id);

    /**
     * Updates the specified resource in storage.
     *
     * @param array|integer $id
     * @param array         $data
     *
     * @return boolean
     */
    public function update($id, $data);
}
