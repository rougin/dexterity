<?php

use Phinx\Seed\AbstractSeed;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class UserSeeder extends AbstractSeed
{
    /**
     * @return void
     */
    public function run(): void
    {
        $items = array();

        $item = array('email' => 'sltr@roug.in');
        $item['name'] = 'Slytherin';
        $item['created_at'] = date('Y-m-d H:i:s');
        $items[] = $item;

        $item = array('email' => 'me@roug.in');
        $item['name'] = 'Rougin Gutib';
        $item['created_at'] = date('Y-m-d H:i:s');
        $items[] = $item;

        $item = array('email' => 'atsm@roug.in');
        $item['name'] = 'Authsum';
        $item['created_at'] = date('Y-m-d H:i:s');
        $items[] = $item;

        $item = array('email' => 'dxtr@roug.in');
        $item['name'] = 'Dexterity';
        $item['created_at'] = date('Y-m-d H:i:s');
        $items[] = $item;

        $item = array('email' => 'cbtr@roug.in');
        $item['name'] = 'Combustor';
        $item['created_at'] = date('Y-m-d H:i:s');
        $items[] = $item;

        $table = $this->table('users');

        $table->insert($items)->saveData();
    }
}
