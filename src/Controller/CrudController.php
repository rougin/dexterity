<?php

namespace Rougin\Dexterity\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Rougin\Dexterity\Repository\RepositoryInterface;

/**
 * CRUD Controller
 *
 * @package Dexterity
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class CrudController implements ControllerInterface
{
    /**
     * The name of the Eloquent model to be used.
     *
     * @var string
     */
    protected $model = '';

    /**
     * The RepositoryInterface object.
     *
     * @var \Rougin\Dexterity\Repository\RepositoryInterface
     */
    protected $repository;

    /**
     * Contains all of the data from the HTTP request.
     *
     * @var \Psr\Http\Message\ServerRequestInterface
     */
    protected $request;

    /**
     * Initializes the controller instance.
     *
     * @param \Rougin\Dexterity\Repository\RepositoryInterface $repository
     * @param \Psr\Http\Message\ServerRequestInterface         $request
     */
    public function __construct(RepositoryInterface $repository, ServerRequestInterface $request)
    {
        $this->request = $request;

        $this->model && $repository->resource($this->model);

        $this->repository = $repository;
    }

    /**
     * Removes the specified resource from storage.
     *
     * @param  array|integer $id
     * @return boolean
     */
    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    /**
     * Displays a listing of the resource.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        $defaults = array('query' => null, 'limit' => null);

        $query = (array) $this->request->getQueryParams();

        $defaults = (array) array_merge($defaults, $query);

        return $this->repository->paginate($limit, $current);
    }

    /**
     * Adds additional input to the ServerRequest instance.
     *
     * @param  array   $parameters
     * @param  boolean $replace
     * @return self
     */
    public function input($parameters, $replace = false)
    {
        $data = $this->request->getParsedBody();

        $data = array_merge($data, $parameters);

        $replace && $data = (array) $parameters;

        $this->request = $this->request->withParsedBody($data);

        return $this;
    }

    /**
     * Sets the name of the Eloquent.
     *
     * @param  string $model
     * @return self
     */
    public function model($model)
    {
        $this->model = $model;

        $this->repository->resource($model);

        return $this;
    }

    /**
     * Stores a newly created resource in storage.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store()
    {
        $data = $this->request->getParsedBody();

        return $this->repository->create($data);
    }

    /**
     * Displays the specified resource.
     *
     * @param  array|integer $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function show($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Updates the specified resource in storage.
     *
     * @param  array|integer $id
     * @return boolean
     */
    public function update($id)
    {
        $data = (array) $this->request->getParsedBody();

        return $this->repository->update($id, $data);
    }

    /**
     * Calls methods from the Repository instance.
     *
     * @param  string $method
     * @param  mixed  $parameters
     * @return self
     */
    public function __call($method, $parameters)
    {
        $class = array($this->repository, (string) $method);

        $this->repository = call_user_func_array($class, $parameters);

        return $this;
    }
}
