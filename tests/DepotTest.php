<?php

namespace Rougin\Dexterity;

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
        $this->loadEloquent();

        $this->depot = new UserDepot(new User);
    }

    /**
     * @return integer
     */
    public function test_create_new_item()
    {
        $payload = array('name' => 'Sample');
        $payload['email'] = 'smpl@roug.in';

        /** @var \Rougin\Dexterity\Fixture\Models\User */
        $result = $this->depot->create($payload);

        $expected = $payload['name'];

        $actual = $result->name;

        $this->assertEquals($expected, $actual);

        return $result->id;
    }

    /**
     * @depends test_update_item
     *
     * @param integer $id
     *
     * @return void
     */
    public function test_delete_item($id)
    {
        $this->assertTrue($this->depot->delete($id));
    }

    /**
     * @return void
     */
    public function test_items_by_offset()
    {
        $expected = 'Dexterity';

        $result = $this->depot->get(4, 1)->toArray();

        /** @var array<string, string>[] */
        $items = $result['items'];

        $actual = $items[0]['name'];

        $this->assertEquals($expected, $actual);
    }

    /**
     * @depends test_create_new_item
     *
     * @param integer $id
     *
     * @return integer
     */
    public function test_update_item($id)
    {
        $payload = array('name' => 'Elpmas');

        $this->depot->update($id, $payload);

        /** @var \Rougin\Dexterity\Fixture\Models\User */
        $result = $this->depot->find($id);

        $expected = $payload['name'];

        $actual = $result->name;

        $this->assertEquals($expected, $actual);

        return $id;
    }
}
