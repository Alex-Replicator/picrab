<?php
namespace Picrab\Core;

class Config
{
    private static $instance;
    private array $config;

    private function __construct(array $config)
    {
        $this->config = $config;
    }

    public static function getInstance(array $config = []): self
    {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    public function get(): array
    {
        return $this->config;
    }

    public function add(string $key, $value): array
    {
        $this->config[$key] = $value;
        return $this->config;
    }

    public function set(array $config): array
    {
        $this->config = $config;
        return $this->config;
    }
}