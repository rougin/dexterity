<?php

namespace Rougin\Dexterity;

use Rougin\Dexterity\Fixture\Depots\ResuDepot;
use Rougin\Dexterity\Fixture\Depots\RoleDepot;
use Rougin\Dexterity\Fixture\Depots\UserDepot;
use Rougin\Dexterity\Fixture\Models\Role;
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
     * @depends test_items_by_offset
     *
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
    public function test_filter_items()
    {
        $depot = new RoleDepot(new Role);

        $expected = array();

        // Create sample roles -----------------
        $row = array('name' => 'Administrator');
        $row['type'] = Role::TYPE_ADMIN;
        $row['slug'] = 'administrator';
        $depot->create($row);

        $row = array('name' => 'Common User');
        $row['type'] = Role::TYPE_USER;
        $row['slug'] = 'common-user';
        $expected[] = $row;
        $depot->create($row);

        $row = array('name' => 'Default User');
        $row['type'] = Role::TYPE_USER;
        $row['slug'] = 'default-user';
        $expected[] = $row;
        $depot->create($row);
        // -------------------------------------

        // Create a filter and add it to the depot ------
        $filter = new Filter;
        $filter->setAsInt('type', Role::TYPE_USER);
        $filter->setAsString('name', 'user')->asSearch();
        $depot->withFilter($filter);
        // ----------------------------------------------

        $actual = $depot->get(1, 5)->items();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function test_items_by_offset()
    {
        $expected = 'Dexterity';

        $depot = new ResuDepot(new User);

        $result = $depot->get(4, 1);

        /** @var array<string, string>[] */
        $items = $result->itemsAsArray();

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

        /** @var array<string, mixed> */
        $result = $this->depot->find($id);

        $expected = $payload['name'];

        $actual = $result['name'];

        $this->assertEquals($expected, $actual);

        return $id;
    }
}
