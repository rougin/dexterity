<?php

namespace Rougin\Dexterity\Error;

use Rougin\Dexterity\Fixture\Routes\Test;
use Rougin\Dexterity\Message\HttpResponse;
use Rougin\Dexterity\Testcase;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class RouteTest extends Testcase
{
    /**
     * @var \Rougin\Dexterity\Fixture\Routes\Test
     */
    protected $route;

    /**
     * @return void
     */
    public function doSetUp()
    {
        $this->route = new Test;
    }

    /**
     * @return void
     */
    public function test_delete_error()
    {
        $request = $this->setRequest();

        $text = 'The "setDeleteData" method must be overwriten in the concrete class.';

        $this->doExpectExceptionMessage($text);

        $this->route->delete(1, $request);
    }

    /**
     * @return void
     */
    public function test_delete_invalid()
    {
        $request = $this->setRequest();

        $this->route->setAsInvalid();

        $response = $this->route->delete(1, $request);

        $expected = HttpResponse::NOT_FOUND;

        $actual = $response->getStatusCode();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function test_index_error()
    {
        $request = $this->setRequest();

        $text = 'The "setIndexData" method must be overwriten in the concrete class.';

        $this->doExpectExceptionMessage($text);

        $this->route->index($request);
    }

    /**
     * @return void
     */
    public function test_index_invalid()
    {
        $request = $this->setRequest();

        $this->route->setAsInvalid();

        $response = $this->route->index($request);

        $expected = HttpResponse::UNPROCESSABLE;

        $actual = $response->getStatusCode();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function test_show_error()
    {
        $request = $this->setRequest();

        $text = 'The "setShowData" method must be overwriten in the concrete class.';

        $this->doExpectExceptionMessage($text);

        $this->route->show(1, $request);
    }

    /**
     * @return void
     */
    public function test_show_invalid()
    {
        $request = $this->setRequest();

        $this->route->setAsInvalid();

        $response = $this->route->show(1, $request);

        $expected = HttpResponse::NOT_FOUND;

        $actual = $response->getStatusCode();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function test_store_error()
    {
        $request = $this->setRequest();

        $text = 'The "setStoreData" method must be overwriten in the concrete class.';

        $this->doExpectExceptionMessage($text);

        $this->route->store($request);
    }

    /**
     * @return void
     */
    public function test_store_invalid()
    {
        $request = $this->setRequest();

        $this->route->setAsInvalid();

        $response = $this->route->store($request);

        $expected = HttpResponse::UNPROCESSABLE;

        $actual = $response->getStatusCode();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function test_update_error()
    {
        $request = $this->setRequest();

        $text = 'The "setUpdateData" method must be overwriten in the concrete class.';

        $this->doExpectExceptionMessage($text);

        $this->route->update(1, $request);
    }

    /**
     * @return void
     */
    public function test_update_invalid()
    {
        $request = $this->setRequest();

        $this->route->setAsInvalid();

        $response = $this->route->update(1, $request);

        $expected = HttpResponse::UNPROCESSABLE;

        $actual = $response->getStatusCode();

        $this->assertEquals($expected, $actual);
    }
}
