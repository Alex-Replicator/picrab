<?php
namespace Picrab\Core;


class Config
{

    public mixed $config;
    public static $instance;

    public static function getInstance($config){
        if(self::$instance === null){
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    private function __construct($config)
    {
        $this->config = $config;
        return $this->get();
    }

    public function add($key, $value)
    {
        $this->config[$key] = $value;
        return $this->get();
    }

    public function set(array $config){
        $this->config = $config;
        return $this->get();
    }

    public function get()
    {
        return $this->config;
    }




}