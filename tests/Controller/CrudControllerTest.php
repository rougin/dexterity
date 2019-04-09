<?php

namespace Rougin\Dexterity\Controller;

use Rougin\Dexterity\Fixture\Repository;
use Rougin\Dexterity\Fixture\Terminator;
use Rougin\Slytherin\Http\ServerRequest;

class CrudControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Rougin\Dexterity\Controller\ControllerInterface
     */
    protected $controller;

    /**
     * Initializes the controller instance.
     */
    public function setUp()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['SERVER_NAME'] = 'localhost';
        $_SERVER['SERVER_PORT'] = '8000';

        $repository = new Repository;

        $request = new ServerRequest($_SERVER);

        $controller = new CrudController($repository, $request);

        $this->controller = $controller;
    }

    /**
     * Tests ControllerInterface::delete.
     *
     * @return void
     */
    public function testDeleteMethod()
    {
        $this->assertTrue($this->controller->delete(1));
    }

    /**
     * Tests ControllerInterface::find.
     *
     * @return void
     */
    public function testFindMethod()
    {
        $expected = new Terminator(1, 'Dex');

        $result = $this->controller->show(1);

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ControllerInterface::index.
     *
     * @return void
     */
    public function testIndexMethod()
    {
        $expected = array(new Terminator(6, 'Dex'));

        $expected[] = new Terminator(7, 'Dex');
        $expected[] = new Terminator(8, 'Dex');
        $expected[] = new Terminator(9, 'Dex');
        $expected[] = new Terminator(10, 'Dex');

        $data = array('page' => 2, 'limit' => 5);

        $this->controller->query($data, true);

        $result = $this->controller->index();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ControllerInterface::store.
     *
     * @return void
     */
    public function testStoreMethod()
    {
        $expected = new Terminator(5, 'Meta');

        $data = array('id' => 5, 'name' => 'Meta');

        $this->controller->input((array) $data);

        $result = $this->controller->store();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ControllerInterface::update.
     *
     * @return void
     */
    public function testUpdateMethod()
    {
        $this->assertTrue($this->controller->update(1));
    }
}
