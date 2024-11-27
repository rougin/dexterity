<?php

$root = __DIR__ . '/Phinx';

$scripts = $root . '/Scripts';
$seeders = $root . '/Seeders';

$phinx = array('paths' => array());
$phinx['paths']['migrations'] = $scripts;
$phinx['paths']['seeds'] = $seeders;
$phinx['version_order'] = 'creation';

$test = array();
$test['adapter'] = 'sqlite';
$test['name'] = __DIR__ . '/Storage/dxtr';
$test['suffix'] = '.s3db';

$envs = array();
$envs['default_migration_table'] = 'phinxlog';
$envs['default_environment'] = 'testing';
$envs['testing'] = $test;

$phinx['environments'] = $envs;

return $phinx;
