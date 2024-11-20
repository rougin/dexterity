<?php

namespace Rougin\Dexterity\Legacy\Repository;

/**
 * Readable Interface
 *
 * @package Dexterity
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
interface ReadableInterface
{
    /**
     * Finds the specified resource from storage.
     *
     * @param  array|integer $id
     * @return mixed
     */
    public function find($id);

    /**
     * Paginates the specified page number and items per page.
     *
     * @param  integer $page
     * @param  integer $limit
     * @return array
     */
    public function paginate($page, $limit);
}
