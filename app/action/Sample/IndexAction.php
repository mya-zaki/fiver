<?php

class Sample_IndexAction extends BaseAction
{
    protected function main()
    {
        $this->title = 'Sample!';
        $this->content_text = '<b>sample</b>';
        $this->default_text = 'Default text.';
        
        $this->list = array(
            'Sample1',
            'Sample2',
            'Sample3',
        );
        
//         $this->view('html');
    }
    
    public function render($view)
    {
        $view->text('head title', $this->title);
        $view->text('#contents h1', $this->content_text);
        $view->html('#contents p span', $this->content_text);
        $view->val('#contents input[name=sample_text]', $this->default_text);
        $view->attr('#contents form[name=sample]', 'action', '/sample');
        
        $view->loop('#contents ul li', array($this, 'callbackLoop'), $this->list);
        
        $view->addClass('#contents ul li:first', 'first');
        $view->removeClass('#contents ul li', 'list');
        
        $view->import('#header', $this->component('common', 'header'));
        $view->import('#footer', $this->component('common', 'footer'));
    }
    
    public function callbackLoop($view_part, $data, $key)
    {
        $view_part->text($data);
    }
    
}
