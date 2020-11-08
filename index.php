<?php
//declare(strict_types=1);

ini_set('display_errors', 1);

require 'vendor/autoload.php';

$kernel = (new \App\Kernel())->boot();
$kernel->handleRequest();

//$container = $kernel->getContainer();
