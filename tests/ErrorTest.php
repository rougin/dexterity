<?php

namespace Rougin\Dexterity;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ErrorTest extends Testcase
{
    /**
     * @var \Rougin\Dexterity\Depot
     */
    protected $depot;

    /**
     * @return void
     */
    public function doSetUp()
    {
        $this->depot = new Depot;
    }

    /**
     * @return void
     */
    public function test_create_error()
    {
        $text = 'The "create" method must be overwriten in the concrete Depot class.';

        $this->doExpectExceptionMessage($text);

        $this->depot->create(array());
    }

    /**
     * @return void
     */
    public function test_delete_error()
    {
        $text = 'The "rowExists" method must be overwriten in the concrete Depot class.';

        $this->doExpectExceptionMessage($text);

        $this->depot->delete(1);
    }

    /**
     * @return void
     */
    public function test_get_error()
    {
        $text = 'The "getItems" method must be overwriten in the concrete Depot class.';

        $this->doExpectExceptionMessage($text);

        $this->depot->get(1, 10);
    }

    /**
     * @return void
     */
    public function test_update_error()
    {
        $text = 'The "update" method must be overwriten in the concrete Depot class.';

        $this->doExpectExceptionMessage($text);

        $this->depot->update(1, array());
    }
}
