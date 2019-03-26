<?php

namespace Rougin\Dexterity\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Rougin\Dexterity\Repository\RepositoryInterface;

/**
 * CRUD Controller
 *
 * @package Dexterity
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class CrudController implements ControllerInterface
{
    /**
     * The name of the entity to be used.
     *
     * @var string
     */
    protected $entity = '';

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

        $this->entity && $repository->entity($this->entity);

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
     * @return array
     */
    public function index()
    {
        $default = array('query' => null, 'limit' => null, 'page' => null);

        $query = (array) $this->request->getQueryParams();

        $default = array_merge($default, (array) $query);

        return $this->repository->paginate($default['page'], $default['limit']);
    }

    /**
     * Adds additional input to the ServerRequest instance.
     *
     * @param  array   $parameters
     * @param  boolean $replace
     * @return self
     */
    public function input(array $parameters, $replace = false)
    {
        return $this->replace($parameters, $replace, 'body');
    }

    /**
     * Sets the name of the resource.
     *
     * @param  string $entity
     * @return self
     */
    public function entity($entity)
    {
        $this->entity = (string) $entity;

        $this->repository->entity($entity);

        return $this;
    }

    /**
     * Adds additional query parameters to the ServerRequest instance.
     *
     * @param  array   $parameters
     * @param  boolean $replace
     * @return self
     */
    public function query(array $parameters, $replace = false)
    {
        return $this->replace($parameters, $replace, 'query');
    }

    /**
     * Stores a newly created resource in storage.
     *
     * @return mixed
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
     * @return mixed
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

    /**
     * Adds additional parameters to the ServerRequest instance.
     *
     * @param  array   $parameters
     * @param  boolean $replace
     * @param  string  $type
     * @return self
     */
    protected function replace(array $parameters, $replace = false, $type)
    {
        $methods = array('query' => 'QueryParams', 'body' => 'ParsedBody');

        $request = array($this->request, 'get' . $methods[$type]);

        $data = call_user_func_array($request, array());

        $data = array_merge((array) $data, $parameters);

        $replace && $data = (array) $parameters;

        $request = array($this->request, 'with' . $methods[$type]);

        $this->request = call_user_func_array($request, array($data));

        return $this;
    }
}
