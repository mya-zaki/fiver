<?php

class Sample_IndexAction extends BaseAction
{
    protected function main()
    {
        $this->content_text = 'Sample!';
    }
    
    public function contents()
    {
        $this->_query->text('Sample!');
    }
}
