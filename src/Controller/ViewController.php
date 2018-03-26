<?php

namespace Rougin\Dexterity\Controller;

use Rougin\Dexterity\Repository\RepositoryInterface;
use Rougin\Slytherin\Template\RendererInterface;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * View Controller
 *
 * @package Dexterity
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
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
     * The template renderer to be used for display the view files.
     *
     * @var \Rougin\Slytherin\Template\RendererInterface
     */
    protected $renderer;

    /**
     * Object used to return the output from the controller.
     *
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * The result from the called methods.
     *
     * @var mixed
     */
    protected $result;

    /**
     * Initializes the controller instance.
     *
     * @param \Rougin\Slytherin\Template\RendererInterface     $renderer
     * @param \Psr\Http\Message\ResponseInterface              $response
     * @param \Rougin\Dexterity\Repository\RepositoryInterface $repository
     * @param \Psr\Http\Message\ServerRequestInterface         $request
     */
    public function __construct(RendererInterface $renderer, ResponseInterface $response, RepositoryInterface $repository, ServerRequestInterface $request)
    {
        parent::__construct($repository, $request);

        $this->renderer = $renderer;

        $this->response = $response;
    }

    /**
     * Shows the form for creating a new resource.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function create()
    {
        $view = sprintf('%s.create', $this->folder);

        $this->file && $view = $this->file;

        $rendered = $this->renderer->render($view, $this->data);

        $this->response->getBody()->write($rendered);

        return $this->response;
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
     * @param  integer $id
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function delete($id)
    {
        $deleted = parent::delete($id);

        return $this->redirect($this->link);
    }

    /**
     * Shows the form for updating a resource.
     *
     * @param  array|integer $id
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function edit($id)
    {
        $this->data['item'] = parent::show($id);

        $view = sprintf('%s.edit', $this->folder);

        $this->file && $view = $this->file;

        $rendered = $this->renderer->render($view, $this->data);

        $this->response->getBody()->write($rendered);

        return $this->response;
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
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index()
    {
        $this->data['result'] = parent::index();

        $view = sprintf('%s.index', $this->folder);

        $this->file && $view = $this->file;

        $rendered = $this->renderer->render($view, $this->data);

        $this->response->getBody()->write($rendered);

        return $this->response;
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
     * @param  array|integer $id
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function show($id)
    {
        $this->data['item'] = $this->result = parent::show($id);

        $view = sprintf('%s.show', $this->folder);

        $this->file && $view = $this->file;

        $rendered = $this->renderer->render($view, $this->data);

        $this->response->getBody()->write($rendered);

        return $this->response;
    }

    /**
     * Stores a newly created resource in storage.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function store()
    {
        $this->result = parent::store();

        return $this->redirect($this->link);
    }

    /**
     * Updates the specified resource in storage.
     *
     * @param  integer $id
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function update($id)
    {
        $this->result = parent::update($id);

        return $this->redirect($this->link);
    }

    /**
     * Returns a redirect response.
     *
     * @param  string $url
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function redirect($url)
    {
        $response = $this->response->withStatus(302);

        return $response->withHeader('Location', $url);
    }
}
