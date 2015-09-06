<?php

class Error_404Action extends Fiver_Action
{
    protected function before()
    {
    }
    
    protected function after()
    {
        $this->response->setHeader('HTTP/1.1 404 Not Found');
    }
    
    protected function main()
    {
        $this->setTemplateDirectory(APP . '/lib/Fiver/template');
    }
    
    protected function render($view)
    {
        
    }
}
