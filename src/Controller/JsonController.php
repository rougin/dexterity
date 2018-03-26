<?php

namespace Rougin\Dexterity\Controller;

use Rougin\Dexterity\Repository\RepositoryInterface;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * JSON Controller
 *
 * @package Dexterity
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class JsonController extends CrudController
{
    /**
     * Object used to return the output from the controller.
     *
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * Initializes the controller instance.
     *
     * @param \Psr\Http\Message\ResponseInterface              $response
     * @param \Rougin\Dexterity\Repository\RepositoryInterface $repository
     * @param \Psr\Http\Message\ServerRequestInterface         $request
     */
    public function __construct(ResponseInterface $response, RepositoryInterface $repository, ServerRequestInterface $request)
    {
        parent::__construct($repository, $request);

        $this->response = $response;
    }

    /**
     * Removes the specified resource from storage.
     *
     * @param  array|integer $id
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function delete($id)
    {
        try {
            list($code, $result) = array(204, null);

            parent::delete($id);
        } catch (\Exception $e) {
            $message = $e->getCode() . ': ' . $e->getMessage();

            list($code, $result) = array(404, $message);
        }

        return $this->json($result, $code);
    }

    /**
     * Displays a listing of the resource.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index()
    {
        return $this->json(parent::index()->toArray(), 200);
    }

    /**
     * Stores a newly created resource in storage.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function store()
    {
        return $this->json(parent::store(), 201);
    }

    /**
     * Displays the specified resource.
     *
     * @param  array|integer $id
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function show($id)
    {
        try {
            $item = parent::show($id)->toArray();

            list($code, $result) = array(200, $item);
        } catch (\Exception $e) {
            $message = $e->getCode() . ': ' . $e->getMessage();

            list($code, $result) = array(404, $message);
        }

        return $this->json($result, $code);
    }

    /**
     * Updates the specified resource in storage.
     *
     * @param  array|integer $id
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function update($id)
    {
        try {
            list($code, $result) = array(204, null);

            parent::update($id);
        } catch (\Exception $e) {
            $message = $e->getCode() . ': ' . $e->getMessage();

            list($code, $result) = array(404, $message);
        }

        return $this->json($result, $code);
    }

    /**
     * Returns the response in JSON format.
     *
     * @param  mixed|null $data
     * @param  integer    $code
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function json($data = null, $code = 200)
    {
        $response = $this->response->withStatus($code);

        $response->getBody()->write(json_encode($data));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
