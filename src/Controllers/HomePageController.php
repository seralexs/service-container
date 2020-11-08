<?php

namespace App\Controllers;

use App\Services\Serializer;
use App\Annotations\Route;

/**
 * Class HomePageController
 * @Route(route="/")
 */
class HomePageController
{
    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @return string
     * @Route(route="/")
     */
    public function index()
    {
        return $this->serializer->serialize([
            'action' => 'Index',
            'time' => time(),
        ]);
    }

    /**
     * @return string
     * @Route(route="/dashboard")
     */
    public function dashboard()
    {
        return $this->serializer->serialize([
            'action' => 'Dashboard',
            'time' => time(),
        ]);
    }

    /**
     * @return string
     * @Route(route="/dashboard/admin")
     */
    public function dashboardAdmin()
    {
        return $this->serializer->serialize([
            'action' => 'Dashboard Admin',
            'time' => time(),
        ]);
    }
}