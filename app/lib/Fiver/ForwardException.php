<?php

class Fiver_ForwardException extends Exception
{
    protected $module_name;
    protected $action_name;
    
    public function __construct($module_name, $action_name)
    {
        parent::__construct($module_name . '/' . $action_name);
        
        $this->module_name = $module_name;
        $this->action_name = $action_name;
    }
    
    public function getModuleName()
    {
        return $this->module_name;
    }
    
    public function getActionName()
    {
        return $this->action_name;
    }
}
