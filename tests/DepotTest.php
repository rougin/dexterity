<?php

namespace Rougin\Dexterity;

use Illuminate\Database\Capsule\Manager;
use Rougin\Dexterity\Fixture\Depots\UserDepot;
use Rougin\Dexterity\Fixture\Models\User;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class DepotTest extends Testcase
{
    /**
     * @var \Rougin\Dexterity\Fixture\Depots\UserDepot
     */
    protected $depot;

    /**
     * @return void
     */
    public function doSetUp()
    {
        $this->loadModel();

        $this->depot = new UserDepot(new User);
    }

    /**
     * @return void
     */
    public function test_returning_items()
    {
        $expected = 5;

        $result = $this->depot->get(1, 10);

        $actual = count($result->items());

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    protected function loadModel()
    {
        $root = __DIR__ . '/Fixture';

        $config = array('driver' => 'sqlite');
        $path = $root . '/Storage/dxtr.s3db';
        $config['database'] = (string) $path;

        $capsule = new Manager;

        $capsule->addConnection($config);

        $capsule->setAsGlobal();

        $capsule->bootEloquent();
    }
}
