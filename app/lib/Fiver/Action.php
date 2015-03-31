<?php
require_once 'FiverTE/FiverTE.php';

abstract class Fiver_Action
{
    const TEMPLATE_EXTENSION = '.html';
    
    protected $buffer = '';
    
    protected $module;
    protected $action;
    
    public $input;
    public $container;
    
    protected $template_dir;
    
    protected $content_type = null; // 'text/html'
    protected $charset = 'utf-8';
    
    public function __construct($module, $action)
    {
        $this->module = $module;
        $this->action = $action;
        
        $this->input     = new Fiver_Input();
        $this->container = new Fiver_Container();
        
        $this->setTemplateDirectory(APP . '/template');
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
//             $this->render(null);
        }
        
        $this->after();
        
        $this->response();
        
        return $this->buffer;
    }
    
    abstract protected function before();
    abstract protected function after();
    abstract protected function main();
    
    final protected function json($data, $charset = 'utf-8')
    {
        $this->buffer       = Zend_Json::encode($data);
        $this->content_type = 'application/json';
        $this->charset      = $charset;
    }
    
    private function response()
    {
        if (isset($this->content_type)) {
            header('Content-Type: ' . $this->content_type . '; charset=utf-8');
        }
    }
    
    protected function render(phpQueryObject $pqdoc = null)
    {
        // Please override.
    }
    
    protected function setTemplateDirectory($dir)
    {
        $this->template_dir = $dir;
    }
    
    protected function component($component_module, $component_name)
    {
        $component_module_lower = strtolower($component_module);
        $component_name_lower   = strtolower($component_name);
        
        $view = new FiverTE($this->template_dir . '/component/' . $component_module_lower . '/' . $component_name_lower . self::TEMPLATE_EXTENSION);
        return $view;
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
