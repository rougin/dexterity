<?php

namespace Rougin\Dexterity;

use Rougin\Dexterity\Fixture\Depots\UserDepot;
use Rougin\Dexterity\Fixture\Models\User;
use Rougin\Dexterity\Fixture\Routes\Users;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class RouteTest extends Testcase
{
    /**
     * @var \Rougin\Dexterity\Fixture\Routes\Users
     */
    protected $route;

    /**
     * @return void
     */
    public function doSetUp()
    {
        $this->loadEloquent();

        $depot = new UserDepot(new User);

        $this->route = new Users($depot);
    }

    /**
     * @depends test_update_method
     *
     * @param integer $id
     *
     * @return void
     */
    public function test_delete_method($id)
    {
        $this->doSetExpectedException('UnexpectedValueException');

        $request = $this->setRequest(array());

        $this->route->delete($id, $request);

        $this->route->show($id, $request);
    }

    /**
     * @return void
     */
    public function test_index_method()
    {
        $request = $this->setRequest(array());

        $response = $this->route->index($request);

        $expect = '{"pages":1,"limit":10,"total":5,"items":[{"id":1,"name":"Slytherin","email":"sltr@roug.in"},{"id":2,"name":"Rougin Gutib","email":"me@roug.in"},{"id":3,"name":"Authsum","email":"atsm@roug.in"},{"id":4,"name":"Dexterity","email":"dxtr@roug.in"},{"id":5,"name":"Combustor","email":"cbtr@roug.in"}]}';

        $actual = $response->getBody()->__toString();

        $this->assertEquals($expect, $actual);
    }

    /**
     * @depends test_index_method
     *
     * @return void
     */
    public function test_show_method()
    {
        $request = $this->setRequest(array());

        $response = $this->route->show(4, $request);

        $expect = '{"id":4,"name":"Dexterity","email":"dxtr@roug.in"}';

        $actual = $response->getBody()->__toString();

        $this->assertEquals($expect, $actual);
    }

    /**
     * @depends test_show_method
     *
     * @return integer
     */
    public function test_store_method()
    {
        $payload = array('name' => 'Hello');
        $payload['email'] = 'hello@roug.in';

        $request = $this->setRequest($payload, true);

        $response = $this->route->store($request);

        $expect = 201;

        $actual = $response->getStatusCode();

        $this->assertEquals($expect, $actual);

        $id = $response->getBody()->__toString();

        /** @var integer */
        return json_decode($id, true);
    }

    /**
     * @depends test_store_method
     *
     * @param integer $id
     *
     * @return integer
     */
    public function test_update_method($id)
    {
        $payload = array('name' => 'Olleh');

        $request = $this->setRequest($payload, true);

        $this->route->update($id, $request);

        $response = $this->route->show($id, $request);

        $expect = '{"id":' . $id . ',"name":"Olleh","email":"hello@roug.in"}';

        $actual = $response->getBody()->__toString();

        $this->assertEquals($expect, $actual);

        return $id;
    }
}
