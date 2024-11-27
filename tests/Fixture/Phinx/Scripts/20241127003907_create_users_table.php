<?php

use Phinx\Migration\AbstractMigration;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
final class CreateUsersTable extends AbstractMigration
{
    /**
     * @return void
     */
    public function change()
    {
        $properties = array('id' => false, 'primary_key' => array('id'));

        $table = $this->table('users', $properties);

        $table
            ->addColumn('id', 'integer', array('limit' => 10, 'identity' => true))
            ->addColumn('name', 'string', array('limit' => 100, 'null' => true))
            ->addColumn('email', 'string', array('limit' => 100, 'null' => true))
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime', array('null' => true))
            ->addColumn('deleted_at', 'datetime', array('null' => true))
            ->create();
    }
}
