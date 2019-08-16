<?php
use midgard\portable\driver;
use midgard\portable\storage\connection;

$dir = dirname(__DIR__) . '/';
require_once $dir . "/vendor/autoload.php";

$schema_dirs = array
(
    $dir . 'var/schemas/',
    $dir . 'vendor/openpsa/midcom/config/'
);

$driver = new driver($schema_dirs, $dir . 'var', '');

// CHANGE PARAMETERS AS REQUIRED:
$db_config = array
(
	'driverOptions' => array(1002 => "SET SESSION sql_mode='ALLOW_INVALID_DATES'"),
    'driver' => 'pdo_mysql',
    'dbname' => 'workshoppy-BA',
    'user' => 'root',
    'password' => 'control17',
);

connection::initialize($driver, $db_config, false);
