<?php

namespace Rougin\Dexterity;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Filter extends Input
{
    /**
     * @var string[]
     */
    protected $keys = array();

    /**
     * @return string[]
     */
    public function getSearchKeys()
    {
        return $this->keys;
    }

    /**
     * @param string|string[] $keys
     *
     * @return self
     */
    public function withSearch($keys)
    {
        if (is_string($keys))
        {
            $keys = array($keys);
        }

        $this->keys = $keys;

        return $this;
    }
}
