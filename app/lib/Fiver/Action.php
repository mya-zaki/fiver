<?php
require_once 'FiverTE/FiverTE.php';

abstract class Fiver_Action //extends Page
{
    protected $buffer = '';
    
//     protected $smoochy;
    const TEMPLATE_EXTENSION = '.html';
    
    protected $module;
    protected $action;
    
    public $input;
    public $container;
    
    protected $template_dir;
    
    public function __construct($module, $action)
    {
        $this->module = $module;
        $this->action = $action;
        
        $this->setTemplateDirectory(APP . '/template');
        
        $this->input = new Fiver_Input();
        
    }
    
    final public function _run()
    {
        $this->before();
        
        $this->main();
        
        try {
            $view = new FiverTE($this->template_dir . '/' . $this->module . '/' . strtolower($this->action) . self::TEMPLATE_EXTENSION);
            $this->render($view);
            $this->buffer = $view->fetch();
        } catch (FiverTE_Exception $fte) {
            $this->render(null);
        }
        
        $this->after();
        
        return $this->buffer;
    }
    
    abstract protected function before();
    abstract protected function after();
    abstract protected function main();
//     abstract protected function render(phpQueryObject $pqdoc = null);
    
    protected function addContainer($name, $data)
    {
        $this->container[$name] = $data;
    }
    
    protected function getContainer($name)
    {
        return $this->container[$name];
    }
    
    protected function setTemplateDirectory($dir)
    {
        $this->template_dir = $dir;
    }
    
//     protected function createMessageObject($name, $message)
//     {
//         $clazz = new stdClass();
//         $clazz->$name = $message;
//         return $clazz;
//     }
    
    protected function redirect($location, $http_code = '302')
    {
        throw new Fiver_RedirectException($location, $http_code);
    }
    
    protected function forward($module_name, $action_name)
    {
        throw new Fiver_ForwardException($module_name, $action_name);
    }
}
