<?php

namespace App\Controllers;

use App\Service\Serializer;

class HomePageController
{
    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    public function index()
    {
        return $this->serializer->serialize([
            'action' => 'Home page',
            'time' => time(),
        ]);
    }
}