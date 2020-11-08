<?php


namespace App\Controllers;

use App\Annotations\Route;
use App\Services\Serializer;

/**
 * Class UserController
 * @Route(route="/users")
 */
class UserController
{
    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @return string
     * @Route(route="/")
     */
    public function users()
    {
        return $this->serializer->serialize([
            'action' => 'Index',
            'time' => time(),
        ]);
    }
}