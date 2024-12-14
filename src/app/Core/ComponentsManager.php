<?php
namespace Picrab\Core;

use ReflectionClass;
use ReflectionMethod;
use Exception;

class ComponentsManager
{
    public array $config;
    private array $components = [];

    public static $instance;

    public static function getInstance(array $config)
    {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }

        return self::$instance;
    }



    private function __construct(array $config)
    {
        $this->config = $config;
        $this->initializeComponents();
    }

    private function initializeComponents()
    {
        $componentsConfig = $this->config['components'];
        foreach ($componentsConfig as $componentName => $componentSettings) {
            if (isset($componentSettings['class'])) {
                $class = $componentSettings['class'];
                $conf = $componentSettings['config'] ?? [];
                if (class_exists($class)) {
                    $reflection = new ReflectionClass($class);
                    $constructor = $reflection->getConstructor();
                    if ($constructor && $constructor->getNumberOfParameters() > 0) {
                        if (!$constructor->isPublic()) {
                            if (method_exists($class, 'getInstance')) {
                                $this->components[$componentName] = $class::getInstance($conf);
                                continue;
                            } else {
                                throw new Exception("Cannot instantiate {$class} because its constructor is not public and no getInstance method is defined.");
                            }
                        }
                        $parameters = [];
                        foreach ($constructor->getParameters() as $param) {
                            $paramType = $param->getType();
                            if ($paramType && !$paramType->isBuiltin()) {
                                $dependencyClass = $paramType->getName();
                                $dependency = $this->getDependency($dependencyClass);
                                if ($dependency) {
                                    $parameters[] = $dependency;
                                } else {
                                    throw new Exception("Unresolved dependency {$dependencyClass} for component {$componentName}");
                                }
                            } else {
                                $parameters[] = $conf[$param->getName()] ?? null;
                            }
                        }
                        $this->components[$componentName] = $reflection->newInstanceArgs($parameters);
                    } else {
                        if (method_exists($class, "getInstance")) {
                            $this->components[$componentName] = $class::getInstance($conf);
                        } else {
                            $constructorCheck = $reflection->getConstructor();
                            if ($constructorCheck && !$constructorCheck->isPublic()) {
                                throw new Exception("Cannot instantiate {$class} because its constructor is not public and no getInstance method is defined.");
                            }
                            $this->components[$componentName] = new $class($conf);
                        }
                    }
                }
            }
        }
    }

    private function getDependency(string $className)
    {
        foreach ($this->components as $component) {
            if ($component instanceof $className) {
                return $component;
            }
        }
        return null;
    }

    public function get(string $componentName)
    {
        return $this->components[$componentName] ?? null;
    }

    public function getAll(): array
    {
        return $this->components;
    }
}