<?php

namespace Rougin\Dexterity\Renderer;

use Illuminate\Contracts\View\Factory;

/**
 * Laravel Blade Renderer
 *
 * @package Concordat
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class BladeRenderer implements RendererInterface
{
    /**
     * @var \Illuminate\Contracts\View\Factory
     */
    protected $factory;

    /**
     * Initializes the renderer instance.
     *
     * @param \Illuminate\Contracts\View\Factory $factory
     */
    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Renders a file into a HTML file.
     *
     * @param  string $file
     * @param  array  $data
     * @return string
     */
    public function render($template, array $data = array())
    {
        return $this->factory->make($template, $data)->render();
    }
}
