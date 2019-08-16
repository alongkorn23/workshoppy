<?php
set_time_limit(0);
require dirname(__DIR__) . '/vendor/autoload.php';

use Thruway\Peer\Router;
use Thruway\Transport\RatchetTransportProvider;

$router = new Router();
$transportProvider = new RatchetTransportProvider("127.0.0.1", 7070);
$router->addTransportProvider($transportProvider);
$router->start();