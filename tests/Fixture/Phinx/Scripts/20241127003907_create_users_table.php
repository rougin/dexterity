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
        $table = $this->table('users');

        $table
            ->addColumn('name', 'string', array('limit' => 100))
            ->addColumn('email', 'string', array('limit' => 100))
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime', array('null' => true))
            ->addColumn('deleted_at', 'datetime', array('null' => true))
            ->create();
    }
}
