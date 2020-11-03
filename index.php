<?php
//declare(strict_types=1);

ini_set('display_errors', 1);

require 'vendor/autoload.php';

use App\Format\JSON;
use App\Format\XML;
use App\Format\YAML;
use App\Format\Interfaces\FormatFromStringInterface;
use App\Format\Interfaces\FormatNameInterface;
use App\Format\BaseFormat;

$data = [
    'first_name' => 'Serhii',
    'last_name' => 'Shpachynskyi',
];

$serializer = new \App\Serializer(new JSON());

echo '<pre>';
var_dump($serializer->serialize($data));

echo '</pre>';
