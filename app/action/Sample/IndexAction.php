<?php

class Sample_IndexAction extends BaseAction
{
    protected function main()
    {
        $this->content_text = 'Sample!';
        
//         $this->view('html');
    }
    
    public function render($view)
    {
        $view->text('#contents', $this->content_text);
    }
}
