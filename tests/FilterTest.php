<?php

namespace Rougin\Dexterity;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class FilterTest extends Testcase
{
    /**
     * @return void
     */
    public function test_bool_with_bool()
    {
        $filter = new Filter;

        $filter->setBool('test', false);

        $actual = $filter->asBool('test');

        $this->assertFalse($actual);
    }

    /**
     * @return void
     */
    public function test_empty_key()
    {
        $filter = new Filter;

        $actual = $filter->asInt('test');

        $this->assertNull($actual);
    }

    /**
     * @return void
     */
    public function test_float_with_float()
    {
        $filter = new Filter;

        $filter->setFloat('test', 100.20);

        $actual = $filter->asFloat('test');

        $this->assertEquals(100.20, $actual);
    }

    /**
     * @return void
     */
    public function test_float_with_null()
    {
        $filter = new Filter;

        $actual = $filter->asFloat('test');

        $this->assertNull($actual);
    }

    /**
     * @return void
     */
    public function test_int_with_int()
    {
        $filter = new Filter;

        $filter->setInt('test', 10);

        $actual = $filter->asInt('test');

        $this->assertEquals(10, $actual);
    }

    /**
     * @return void
     */
    public function test_int_with_null()
    {
        $filter = new Filter;

        $actual = $filter->asInt('test');

        $this->assertNull($actual);
    }

    /**
     * @return void
     */
    public function test_string_with_null()
    {
        $filter = new Filter;

        $actual = $filter->asStr('test');

        $this->assertNull($actual);
    }

    /**
     * @return void
     */
    public function test_string_with_string()
    {
        $filter = new Filter;

        $filter->setStr('test', '10000');

        $actual = $filter->asStr('test');

        $this->assertEquals('10000', $actual);
    }

    /**
     * @return void
     */
    public function test_true_float()
    {
        $filter = new Filter;

        $filter->setFloat('test', 100.234);

        $actual = $filter->asTrueFloat('test');

        $this->assertEquals(100.234, $actual);
    }

    /**
     * @return void
     */
    public function test_true_float_with_error()
    {
        $filter = new Filter;

        $this->doSetExpectedException('Exception');

        $filter->asTrueFloat('test');
    }

    /**
     * @return void
     */
    public function test_true_integer()
    {
        $filter = new Filter;

        $filter->setInt('test', 10000);

        $actual = $filter->asTrueInt('test');

        $this->assertEquals(10000, $actual);
    }

    /**
     * @return void
     */
    public function test_true_integer_with_error()
    {
        $filter = new Filter;

        $this->doSetExpectedException('Exception');

        $filter->asTrueInt('test');
    }

    /**
     * @return void
     */
    public function test_true_string()
    {
        $filter = new Filter;

        $filter->setStr('test', '10000');

        $actual = $filter->asTrueStr('test');

        $this->assertEquals('10000', $actual);
    }

    /**
     * @return void
     */
    public function test_true_string_with_error()
    {
        $filter = new Filter;

        $this->doSetExpectedException('Exception');

        $filter->asTrueStr('test');
    }
}
