<?php

class Error_500Action extends Fiver_Action
{
    protected function before()
    {
    }
    
    protected function after()
    {
        $this->response->setHeader('HTTP/1.1 500 Internal Server Error');
    }
    
    protected function main()
    {
        $this->setTemplateDirectory(APP . '/lib/Fiver/template');
    }
    
    protected function render($view)
    {
        
    }
}
