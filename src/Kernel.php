<?php


namespace App;


use App\Annotations\Route;
use App\Format\Interfaces\FormatInterface;
use App\Format\JSON;
use App\Format\XML;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

class Kernel
{
    private $container;
    private $routes = [];

    public function __construct()
    {
        $this->container = new Container();
    }

    public function getContainer(): Container
    {
        return $this->container;
    }

    public function boot()
    {
        $this->bootContainer();

        return $this;
    }

    private function bootContainer()
    {
        $this->container->addService(JSON::class, function () {
            return new JSON();
        });

        $this->container->addService(XML::class, function () {
            return new XML();
        });

        $this->container->addService('format', function () {
            return $this->container->getService(JSON::class);
        }, FormatInterface::class);

        $this->container->loadServices('App\\Services');

        AnnotationRegistry::registerLoader('class_exists');
        $reader = new AnnotationReader();

        $routes = [];

        $this->container->loadServices(
            'App\\Controllers',
            function (string $serviceName, \ReflectionClass $reflectionClass) use ($reader, &$routes) {
                $route = $reader->getClassAnnotation($reflectionClass, Route::class);

                if (!$route) return;

                $baseRoute = $route->route;

                foreach ($reflectionClass->getMethods() as $method) {
                    $route = $reader->getMethodAnnotation($method, Route::class);

                    if (!$route) continue;

                    $routes[str_replace('//', '/', $baseRoute . $route->route)] = [
                        'service' => $serviceName,
                        'method' => $method->getName(),
                    ];
                }
            }
        );
//var_dump($routes);
        $this->routes = $routes;
    }

    public function handleRequest()
    {
        $uri = $_SERVER['REQUEST_URI'];

        if (isset($this->routes[$uri])) {
            $route = $this->routes[$uri];
            $response = $this->container->getService($route['service'])
                ->{$route['method']}();

            echo $response;
            die;
        }
    }
}