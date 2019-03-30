<?php

namespace Rougin\Dexterity\Renderer;

/**
 * Renderer Interface
 *
 * An interface for handling third party template engines.
 *
 * @package Dexterity
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
interface RendererInterface
{
    /**
     * Renders a file into a HTML file.
     *
     * @param  string $file
     * @param  array  $data
     * @return string
     */
    public function render($file, array $data = array());
}
