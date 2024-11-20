<?php

namespace Rougin\Dexterity\Legacy\Renderer;

/**
 * Twig Renderer
 *
 * @package Dexterity
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class TwigRenderer implements RendererInterface
{
    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * Initializes the renderer interface.
     *
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Renders a file into a HTML file.
     *
     * @param  string $file
     * @param  array  $data
     * @return string
     */
    public function render($file, array $data = array())
    {
        return $this->twig->render($file, $data);
    }

    /**
     * Calls a method from the Twig instance.
     *
     * @param  string $method
     * @param  mixed  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        $instance = array($this->twig, (string) $method);

        return call_user_func_array($instance, $parameters);
    }
}
