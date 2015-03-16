<?php
// require_once 'Smoochy/Smoochy.php';
require_once 'phpQuery/phpQuery-onefile.php';

abstract class Fiver_Action //extends Page
{
    protected $buffer = '';
    
//     protected $smoochy;
    
    protected $module;
    protected $action;
    
    public $input;
    public $container;
    
    protected $template;
    protected $template_extension = '.html';
    
    public function __construct($module, $action)
    {
//         $this->smoochy = new Smoochy();
//         $this->setTemplateDirectory(APP . '/template/');

        $this->module = $module;
        $this->action = $action;
        
        $this->setTemplate($module . '/' . strtolower($action) . $this->template_extension);
        
        // APP . '/template/' . 
        
        $this->input = new Fiver_Input();
    }
    
    final public function _run()
    {
        $this->before();
        
        // cache
        
        $this->main();
        
        $this->_render();
        
        $this->after();
        
        // /cache
        
        return $this->buffer;
    }
    
    abstract protected function before();
    abstract protected function after();
    abstract protected function main();
    abstract protected function render(phpQueryObject $pqdoc);
    
    protected function addContainer($name, $data)
    {
        $this->container[$name] = $data;
    }
    
    protected function getContainer($name)
    {
        return $this->container[$name];
    }
    
    protected function setTemplate($path)
    {
        $this->template = $path;
    }
    
//     protected function createMessageObject($name, $message)
//     {
//         $clazz = new stdClass();
//         $clazz->$name = $message;
//         return $clazz;
//     }
    
    private function _render()
    {
        $pqdoc = phpQuery::newDocumentFile(APP . '/template/' . $this->template);
        
        $this->render($pqdoc);
//         parent::__construct();
//         $this->buffer = $this->smoochy->execute($this);
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
