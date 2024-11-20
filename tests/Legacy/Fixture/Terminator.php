<?php

namespace Rougin\Dexterity\Legacy\Fixture;

/**
 * Terminator
 *
 * @package Dexterity
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Terminator
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * Initializes the class.
     *
     * @param integer $id
     * @param string  $name
     */
    public function __construct($id, $name = 'Dex')
    {
        $this->id = $id;

        $this->name = $name;
    }

    /**
     * Returns the ID.
     *
     * @return integer
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * Returns the name.
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }
}
