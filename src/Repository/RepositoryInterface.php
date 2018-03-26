<?php

namespace Rougin\Dexterity\Repository;

/**
 * Repository Interface
 *
 * @package Dexterity
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface RepositoryInterface
{
    /**
     * Stores a newly created resource in storage.
     *
     * @param  array $data
     * @return mixed
     */
    public function create($data);

    /**
     * Deletes the specified resource from storage.
     *
     * @param  array|integer $id
     * @return boolean
     */
    public function delete($id);

    /**
     * Finds the specified resource from storage.
     *
     * @param  array|integer $id
     * @return mixed
     */
    public function find($id);

    /**
     * Sets the resource for the repository.
     *
     * @param  string $resource
     * @return self
     */
    public function resource($resource);

    /**
     * Paginates the specified page number and items per page.
     *
     * @param  integer $page
     * @param  integer $limit
     * @return array
     */
    public function paginate($page, $limit);

    /**
     * Updates the specified resource in storage.
     *
     * @param  array|integer $id
     * @param  array         $data
     * @return boolean
     */
    public function update($id, $data);
}
