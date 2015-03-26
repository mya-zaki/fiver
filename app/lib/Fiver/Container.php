<?php

class Fiver_Container
{
    /** @var array arbitrarily data */
    private $container = null;
    
    public function __construct()
    {
    }
    
    public function get($name, $default = null)
    {
        return isset($this->container[$name])?$this->container[$name]:$default;
    }
    
    protected function set($name, $data)
    {
        $this->container[$name] = $data;
    }
    
}
