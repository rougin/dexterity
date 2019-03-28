<?php

namespace Rougin\Dexterity\Controller;

use Psr\Http\Message\ResponseInterface;
use Rougin\Dexterity\Renderer\RendererInterface;

/**
 * View Controller
 *
 * @package Dexterity
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class ViewController extends CrudController
{
    /**
     * Values to be passed into the view.
     *
     * @var array
     */
    protected $data = array();

    /**
     * The location of the specified file.
     *
     * @var string
     */
    protected $file = '';

    /**
     * The location of the view files.
     *
     * @var string
     */
    protected $folder = '';

    /**
     * The redirection link after completing a process (delete, create, update).
     *
     * @var string
     */
    protected $link = '/';

    /**
     * The result from the called methods.
     *
     * @var mixed
     */
    protected $result;

    /**
     * Shows the form for creating a new resource.
     *
     * @param  \Rougin\Dexterity\Renderer\RendererInterface $renderer
     * @return string
     */
    public function create(RendererInterface $renderer)
    {
        $view = sprintf('%s.create', $this->folder);

        $this->file && $view = (string) $this->file;

        return $renderer->render($view, $this->data);
    }

    /**
     * Sets the values to be passed into the view.
     *
     * @param  array $data
     * @return self
     */
    public function data(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Removes the specified resource from storage.
     *
     * @param  \Psr\Http\Message\ResponseInterface $response
     * @param  integer $id
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function delete(ResponseInterface $response, $id)
    {
        $deleted = parent::delete((integer) $id);

        return $this->redirect($response, $this->link);
    }

    /**
     * Shows the form for updating a resource.
     *
     * @param  \Rougin\Dexterity\Renderer\RendererInterface $renderer
     * @param  array|integer                                $id
     * @return string
     */
    public function edit(RendererInterface $renderer, $id)
    {
        $this->data['item'] = parent::show((integer) $id);

        $view = sprintf('%s.edit', $this->folder);

        $this->file && $view = (string) $this->file;

        return $renderer->render($view, $this->data);
    }

    /**
     * Sets the file name for the selected view template.
     *
     * @param  string $file
     * @return self
     */
    public function file($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Sets the folder name for the controller.
     *
     * @param  string $folder
     * @return self
     */
    public function folder($folder)
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * Displays a listing of the resource.
     *
     * @param  \Rougin\Dexterity\Renderer\RendererInterface $renderer
     * @return string
     */
    public function index(RendererInterface $renderer)
    {
        $view = sprintf('%s.index', $this->folder);

        $this->data['result'] = parent::index();

        $this->file && $view = (string) $this->file;

        return $renderer->render($view, $this->data);
    }

    /**
     * Sets the redirection link for the controller.
     *
     * @param  string $link
     * @return self
     */
    public function link($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Returns the result from the called methods.
     *
     * @return mixed
     */
    public function result()
    {
        return $this->result;
    }

    /**
     * Displays the specified resource.
     *
     * @param  \Rougin\Dexterity\Renderer\RendererInterface $renderer
     * @param  array|integer                                $id
     * @return string
     */
    public function show($id)
    {
        $view = sprintf('%s.show', (string) $this->folder);

        $this->data['item'] = $this->result = parent::show($id);

        $this->file && $view = (string) $this->file;

        return $renderer->render($view, $this->data);
    }

    /**
     * Stores a newly created resource in storage.
     *
     * @param  \Psr\Http\Message\ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function store(ResponseInterface $response)
    {
        $this->result = parent::store();

        return $this->redirect($response, $this->link);
    }

    /**
     * Updates the specified resource in storage.
     *
     * @param  \Psr\Http\Message\ResponseInterface $response
     * @param  integer                             $id
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function update(ResponseInterface $response, $id)
    {
        $this->result = parent::update((integer) $id);

        return $this->redirect($response, $this->link);
    }

    /**
     * Returns a HTTP 301 response back to the user.
     *
     * @param  \Psr\Http\Message\ResponseInterface $response
     * @param  string                              $url
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function redirect(ResponseInterface $response, $url)
    {
        return $response->withStatus(302)->withHeader('Location', $url);
    }
}
