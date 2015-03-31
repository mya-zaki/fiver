<?php

class Sample_JsonAction extends BaseAction
{
    protected function main()
    {
        $this->title = 'Sample!';
        $this->content_text = '<b>sample</b>';
        $this->default_text = 'Default text.';
        
        $this->data = array(
            'title' => 'Sample!',
            'content_text' => '<b>sample</b>',
            'default_text' => 'Default text.',
            'list' => array(
                'Sample1',
                'Sample2',
                'Sample3',
            ),
        );
        
         $this->json($this->data);
    }
}
