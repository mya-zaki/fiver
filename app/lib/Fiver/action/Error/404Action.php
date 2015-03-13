<?php

class Error_404Action extends Fiver_Action
{
    protected function before()
    {
    }
    
    protected function after()
    {
    }
    
    public function __construct()
    {
        $this->smoochy = new Smoochy();
        $this->setTemplateDirectory(APP . '/lib/Fiver/template/');
    
        $this->input = new Fiver_Input();
    }
    
    protected function main()
    {
        header('HTTP/1.1 404 Not Found');
    }
}
