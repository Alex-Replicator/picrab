<?php

namespace Picrab\Core;

class Container
{
    private array $bindings = [];
    private array $instances = [];

    public function bind(string $abstract, callable $factory)
    {
        $this->bindings[$abstract] = $factory;
    }

    public function singleton(string $abstract, callable $factory)
    {
        $this->bindings[$abstract] = function ($container) use ($factory) {
            if (!isset($this->instances[$abstract])) {
                $this->instances[$abstract] = $factory($container);
            }
            return $this->instances[$abstract];
        };
    }

    public function get(string $abstract)
    {
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        if (isset($this->bindings[$abstract])) {
            $factory = $this->bindings[$abstract];
            return $factory($this);
        }

        throw new \RuntimeException("No binding found for {$abstract}");
    }
}