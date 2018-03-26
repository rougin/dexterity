<?php

namespace Rougin\Dexterity\Repository;

/**
 * Eloquent Repository
 *
 * @package Dexterity
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class EloquentRepository implements RepositoryInterface
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $eloquent;

    /**
     * Stores a newly created resource in storage.
     *
     * @param  array $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->eloquent->create($data);
    }

    /**
     * Deletes the specified resource from storage.
     *
     * @param  array|integer $id
     * @return boolean
     */
    public function delete($id)
    {
        return $this->find($id)->delete();
    }

    /**
     * Finds the specified resource from storage.
     *
     * @param  array|integer $id
     * @return mixed
     */
    public function find($id)
    {
        if (is_array($id) === true) {
            $item = $this->eloquent->where($id);

            return $item->firstOrFail();
        }

        return $this->eloquent->findOrFail($id);
    }

    /**
     * Sets the resource for the repository.
     *
     * @param  string $resource
     * @return self
     */
    public function resource($resource)
    {
        $this->eloquent = new $resource;

        return $this;
    }

    /**
     * Paginates the specified page number and items per page.
     *
     * @param  integer $page
     * @param  integer $limit
     * @return array
     */
    public function paginate($page, $limit)
    {
        return $this->eloquent->paginate($limit, ['*'], 'page', $page);
    }

    /**
     * Updates the specified resource in storage.
     *
     * @param  array|integer $id
     * @param  array         $data
     * @return boolean
     */
    public function update($id, $data)
    {
        return $this->find($id)->update($data);
    }

    /**
     * Calls methods from the Eloquent instance.
     *
     * @param  string $method
     * @param  mixed  $parameters
     * @return self
     */
    public function __call($method, $parameters)
    {
        $class = array($this->eloquent, $method);

        $this->eloquent = call_user_func_array($class, $parameters);

        return $this;
    }
}
