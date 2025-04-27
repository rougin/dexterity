<?php

namespace Rougin\Dexterity;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Filter
{
    /**
     * @var array<string, mixed>
     */
    protected $items = array();

    /**
     * @var string|null
     */
    protected $search = null;

    /**
     * @return self
     */
    public function asSearch()
    {
        $keys = array_keys($this->items);

        $last = count($keys) - 1;

        $this->search = $keys[$last];

        return $this;
    }

    /**
     * @param string $name
     *
     * @return integer
     */
    public function getAsInt($name)
    {
        return (int) $this->getAsIntNull($name);
    }

    /**
     * @param string $name
     *
     * @return integer|null
     */
    public function getAsIntNull($name)
    {
        $value = $this->getAsStringNull($name);

        return $value ? (int) $value : null;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public function getAsString($name)
    {
        return (string) $this->getAsStringNull($name);
    }

    /**
     * @param string $name
     *
     * @return string|null
     */
    public function getAsStringNull($name)
    {
        $exists = array_key_exists($name, $this->items);

        /** @var string|null */
        return $exists ? $this->items[$name] : null;
    }

    /**
     * @return array<string, mixed>
     */
    public function getData()
    {
        return $this->items;
    }

    /**
     * @return string|null
     */
    public function getSearchKey()
    {
        return $this->search;
    }

    /**
     * @param string  $name
     * @param integer $value
     *
     * @return self
     */
    public function setAsInt($name, $value)
    {
        $this->items[$name] = (int) $value;

        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return self
     */
    public function setAsString($name, $value)
    {
        $this->items[$name] = (string) $value;

        return $this;
    }
}
