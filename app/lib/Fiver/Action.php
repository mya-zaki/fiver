<?php
require_once 'Smoochy/Smoochy.php';

abstract class Fiver_Action extends Page
{
    protected $buffer = '';
    
    protected $smoochy;
    
    public $input;
    public $container;
    
    public function __construct()
    {
        $this->smoochy = new Smoochy();
        $this->setTemplateDirectory(APP . '/template/');
        
        $this->input = new Fiver_Input();
    }
    
    final public function _run()
    {
        $this->before();
        $this->main();
        
        $this->render();
        
        $this->after();
        
        return $this->buffer;
    }
    
    abstract protected function before();
    abstract protected function after();
    abstract protected function main();
    
    protected function addContainer($name, $data)
    {
        $this->container[$name] = $data;
    }
    
    protected function getContainer($name)
    {
        return $this->container[$name];
    }
    
//     protected function createMessageObject($name, $message)
//     {
//         $clazz = new stdClass();
//         $clazz->$name = $message;
//         return $clazz;
//     }
    
    private function render()
    {
        parent::__construct();
        $this->buffer = $this->smoochy->execute($this);
    }
    
    protected function redirect($location, $http_code = '302')
    {
        throw new Fiver_RedirectException($location, $http_code);
    }
    
    protected function forward($module_name, $action_name)
    {
        throw new Fiver_ForwardException($module_name, $action_name);
    }
}
