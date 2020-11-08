<?php
//declare(strict_types=1);

ini_set('display_errors', 1);

require 'vendor/autoload.php';

use App\Format\JSON;
use App\Format\XML;
use App\Controllers\HomePageController;
use App\Container;
use App\Format\Interfaces\FormatInterface;

$data = [
    'first_name' => 'Serhii',
    'last_name' => 'Shpachynskyi',
];

$container = new Container();

$container->addService(JSON::class, function () {
    return new JSON();
});

$container->addService(XML::class, function () {
    return new XML();
});

$container->addService('format', function () use ($container) {
    return $container->getService(JSON::class);
}, FormatInterface::class);

//$container->addService(Serializer::class, function () use ($container) {
//    return new Serializer($container->getService('format'));
//});

//$container->addService(HomePageController::class, function () use ($container) {
//    return new HomePageController($container->getService(Serializer::class));
//});

$container->loadServices('App\\Services');
$container->loadServices('App\\Controllers');

echo '<pre>';
var_dump($container->getService(HomePageController::class)->index());
var_dump($container->getServices());
echo '</pre>';
