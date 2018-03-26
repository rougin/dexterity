<?php

namespace Rougin\Dexterity\Controller;

/**
 * Controller Interface
 *
 * @package Dexterity
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface ControllerInterface
{
    /**
     * Removes the specified resource from storage.
     *
     * @param  array|integer $id
     * @return boolean
     */
    public function delete($id);

    /**
     * Displays a listing of the resource.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index();

    /**
     * Stores a newly created resource in storage.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store();

    /**
     * Displays the specified resource.
     *
     * @param  array|integer $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function show($id);

    /**
     * Updates the specified resource in storage.
     *
     * @param  array|integer $id
     * @return boolean
     */
    public function update($id);
}
