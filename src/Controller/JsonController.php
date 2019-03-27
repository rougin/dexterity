<?php

namespace Rougin\Dexterity\Controller;

use Psr\Http\Message\ResponseInterface;

/**
 * JSON Controller
 *
 * @package Dexterity
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class JsonController extends CrudController
{
    /**
     * Removes the specified resource from storage.
     *
     * @param  \Psr\Http\Message\ResponseInterface $response
     * @param  array|integer                       $id
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function delete(ResponseInterface $response, $id)
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
     * @param  \Psr\Http\Message\ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index(ResponseInterface $response)
    {
        $items = (array) parent::index()->toArray();

        return $this->json($response, $items, 200);
    }

    /**
     * Stores a newly created resource in storage.
     *
     * @param  \Psr\Http\Message\ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function store(ResponseInterface $response)
    {
        return $this->json($response, parent::store(), 201);
    }

    /**
     * Displays the specified resource.
     *
     * @param  \Psr\Http\Message\ResponseInterface $response
     * @param  array|integer                       $id
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function show(ResponseInterface $response, $id)
    {
        try {
            $item = (array) parent::show($id)->toArray();

            list($code, $result) = array(200, $item);
        } catch (\Exception $error) {
            $message = (string) $error->getCode() . ': ';

            $message = $message . $error->getMessage();

            list($code, $result) = array(404, $message);
        }

        return $this->json($response, $result, $code);
    }

    /**
     * Updates the specified resource in storage.
     *
     * @param  \Psr\Http\Message\ResponseInterface $response
     * @param  array|integer                       $id
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function update(ResponseInterface $response, $id)
    {
        try {
            list($code, $result) = array(204, null);

            parent::update((integer) $id);
        } catch (\Exception $error) {
            $message = (string) $error->getCode() . ': ';

            $message = $message . $error->getMessage();

            list($code, $result) = array(404, $message);
        }

        return $this->json($result, $code);
    }

    /**
     * Returns the response in "application/json" content.
     *
     * @param  \Psr\Http\Message\ResponseInterface $response
     * @param  mixed|null                          $data
     * @param  integer                             $code
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function json(ResponseInterface $response, $data = null, $code = 200)
    {
        $response = $response->withStatus((integer) $code);

        $response->getBody()->write(json_encode($data));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
