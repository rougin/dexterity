<?php

namespace Rougin\Dexterity;

use Rougin\Dexterity\Fixture\Models\Role;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class FilterTest extends Testcase
{
    /**
     * @var \Rougin\Dexterity\Filter
     */
    protected $filter;

    /**
     * @return void
     */
    public function doSetUp()
    {
        $this->loadEloquent();

        $filter = new Filter;

        $filter->setAsInt('type', Role::TYPE_USER);

        $filter->setAsString('name', 'user')->asSearch();

        $this->filter = $filter;
    }

    /**
     * @return void
     */
    public function test_as_integer()
    {
        $expected = Role::TYPE_USER;

        $actual = $this->filter->getAsInt('type');

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function test_as_integer_null()
    {
        $actual = $this->filter->getAsIntNull('sample');

        $this->assertNull($actual);
    }

    /**
     * @return void
     */
    public function test_as_string()
    {
        $expected = 'user';

        $actual = $this->filter->getAsString('name');

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function test_as_string_null()
    {
        $actual = $this->filter->getAsStringNull('sample');

        $this->assertNull($actual);
    }
}
