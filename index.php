<?php
//declare(strict_types=1);

ini_set('display_errors', 1);

require 'vendor/autoload.php';

use App\Format\JSON;
use App\Format\XML;
use App\Service\Serializer;
use App\Controllers\HomePageController;
use App\Container;

$data = [
    'first_name' => 'Serhii',
    'last_name' => 'Shpachynskyi',
];

$container = new Container();

$container->addService('format.json', function () {
    return new JSON();
});

$container->addService('format.xml', function () {
    return new XML();
});

$container->addService('format', function () use ($container) {
    return $container->getService('format.json');
});

$container->addService('serializer', function () use ($container) {
    return new Serializer($container->getService('format'));
});

$container->addService('controller.home', function () use ($container) {
    return new HomePageController($container->getService('serializer'));
});

echo '<pre>';
var_dump($container->getService('controller.home')->index());
echo '</pre>';
