<?php

abstract class BaseAction extends Fiver_Action
{
    protected function before()
    {
    }
    
    protected function after()
    {
    }
    
    public function header()
    {
        $this->_query->import(new Component_Header());
    }
    
    public function footer()
    {
        $this->_query->import(new Component_Footer());
    }
    
}
