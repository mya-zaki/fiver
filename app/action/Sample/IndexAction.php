<?php

class Sample_IndexAction extends BaseAction
{
    protected function main()
    {
        
    }
    
    public function contents()
    {
        $this->_query->text('Sample!');
    }
}
