<?php

use Phinx\Migration\AbstractMigration;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
final class CreateRolesTable extends AbstractMigration
{
    /**
     * @return void
     */
    public function change()
    {
        $table = $this->table('roles');

        $table
            ->addColumn('type', 'integer', array('limit' => 1))
            ->addColumn('slug', 'string', array('limit' => 100))
            ->addColumn('name', 'string', array('limit' => 100))
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime', array('null' => true))
            ->addColumn('deleted_at', 'datetime', array('null' => true))
            ->create();
    }
}
