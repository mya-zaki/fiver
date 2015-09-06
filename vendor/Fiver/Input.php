<?php

class Fiver_Input
{
    /** @var array GET, POST */
    private $request;
    
    public function __construct()
    {
        $this->request = array_merge($_GET, $_POST);
    }
    
    public function get($key, $default = null)
    {
        return isset($this->request[$key])?$this->request[$key]:$default;
    }
    
}
