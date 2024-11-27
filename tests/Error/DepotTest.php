<?php

namespace Rougin\Dexterity\Error;

use Rougin\Dexterity\Depot;
use Rougin\Dexterity\Fixture\Depots\TestDepot;
use Rougin\Dexterity\Testcase;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class DepotTest extends Testcase
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
        $text = 'The "create" method must be overwriten in the concrete class.';

        $this->doExpectExceptionMessage($text);

        $this->depot->create(array());
    }

    /**
     * @return void
     */
    public function test_delete_error()
    {
        $text = 'The "rowExists" method must be overwriten in the concrete class.';

        $this->doExpectExceptionMessage($text);

        $this->depot->delete(1);
    }

    /**
     * @return void
     */
    public function test_delete_error_without_logic()
    {
        $depot = new TestDepot;

        $text = 'The "deleteRow" method must be overwriten in the concrete class.';

        $this->doExpectExceptionMessage($text);

        $depot->delete(1);
    }

    /**
     * @return void
     */
    public function test_empty_parsed_row()
    {
        $depot = new TestDepot;

        $expected = array();

        $actual = $depot->find(1);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function test_find_error()
    {
        $text = 'The "findRow" method must be overwriten in the concrete class.';

        $this->doExpectExceptionMessage($text);

        $this->depot->find(1);
    }

    /**
     * @return void
     */
    public function test_get_error()
    {
        $text = 'The "getItems" method must be overwriten in the concrete class.';

        $this->doExpectExceptionMessage($text);

        $this->depot->get(1, 10);
    }

    /**
     * @return void
     */
    public function test_get_error_without_total()
    {
        $depot = new TestDepot;

        $text = 'The "getTotal" method must be overwriten in the concrete class.';

        $this->doExpectExceptionMessage($text);

        $depot->get(1, 10);
    }

    /**
     * @return void
     */
    public function test_update_error()
    {
        $text = 'The "update" method must be overwriten in the concrete class.';

        $this->doExpectExceptionMessage($text);

        $this->depot->update(1, array());
    }
}
