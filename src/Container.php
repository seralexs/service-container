<?php


namespace App;


class Container
{
    private $services = [];

    private $aliases = [];

    public function addService(
        string $name,
        \Closure $closure,
        ?string $alias = null
    ): void
    {
        $this->services[$name] = $closure;

        if ($alias) {
            $this->addAlias($alias, $name);
        }
    }

    public function addAlias(string $alias, string $service): void
    {
        $this->aliases[$alias] = $service;
    }

    public function hasService(string $name): bool
    {
        return isset($this->services[$name]);
    }

    public function hasAlias(string $name): bool
    {
        return isset($this->aliases[$name]);
    }

    public function getService(string $name)
    {
        if (!$this->hasService($name)) return null;

        if ($this->services[$name] instanceof \Closure) {
            $this->services[$name] = $this->services[$name]();
        }

        return $this->services[$name];
    }

    public function getAlias(string $name)
    {
        return $this->getService($this->aliases[$name]);
    }

    public function getServices(): array
    {
        return [
            'services' => array_keys($this->services),
            'aliases' => $this->aliases,
        ];
    }

    public function loadServices(string $namespace, ?\Closure $callback = null)
    {
        $baseDir = __DIR__ . '/';

        $actualDirectory = str_replace('\\', '/', $namespace);

        $actualDirectory = $baseDir . substr(
            $actualDirectory,
            strpos($actualDirectory, '/') + 1
        );
        $files = array_filter(scandir($actualDirectory), function ($file) {
            return $file !== '.' && $file !== '..';
        });

        foreach ($files as $file) {
            $reflectionClass = new \ReflectionClass(
                $namespace . '\\' . basename($file, '.php')
            );

            $serviceName = $reflectionClass->getName();

            $constructor = $reflectionClass->getConstructor();
            $parameters = $constructor->getParameters();

            $serviceParameters = [];

            foreach ($parameters as $parameter) {
                $type = (string)$parameter->getType();
//var_dump($type);
                if ($this->hasService($type) || $this->hasAlias($type)) {
//                    var_dump('if');
                    $serviceParameters[] = $this->getService($type)
                        ?? $this->getAlias($type);
                } else {
//                    var_dump('else');
                    $serviceParameters[] = function () use ($type) {
                        return $this->getService($type)
                            ?? $this->getAlias($type);
                    };
                }
            }
//var_dump($serviceParameters);
            $this->addService($serviceName, function () use ($serviceName, $serviceParameters) {
                foreach ($serviceParameters as &$serviceParameter) {
                    if ($serviceParameter instanceof \Closure) {
                        $serviceParameter = $serviceParameter();
                    }
                }

                return new $serviceName(...$serviceParameters);
            });
//            var_dump($constructor->getParameters());

            if ($callback) {
                $callback($serviceName, $reflectionClass);
            }
        }

    }
}