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
     * @return void
     */
    public function test_index_method()
    {
        $request = $this->setRequest('GET', '/');

        $response = $this->route->index($request);

        $expected = '{"pages":1,"limit":10,"total":5,"items":[{"id":1,"name":"Slytherin","email":"sltr@roug.in","created_at":"2024-11-27T00:46:59.000000Z","updated_at":null,"deleted_at":null},{"id":2,"name":"Rougin Gutib","email":"me@roug.in","created_at":"2024-11-27T00:46:59.000000Z","updated_at":null,"deleted_at":null},{"id":3,"name":"Authsum","email":"atsm@roug.in","created_at":"2024-11-27T00:46:59.000000Z","updated_at":null,"deleted_at":null},{"id":4,"name":"Dexterity","email":"dxtr@roug.in","created_at":"2024-11-27T00:46:59.000000Z","updated_at":null,"deleted_at":null},{"id":5,"name":"Combustor","email":"cbtr@roug.in","created_at":"2024-11-27T00:46:59.000000Z","updated_at":null,"deleted_at":null}]}';

        $actual = $response->getBody()->__toString();

        $this->assertEquals($expected, $actual);
    }
}
