<?php

class Component_Base extends Page
{
    public function __construct()
    {
        $this->smoochy = new Smoochy();
        $this->setTemplateDirectory(APP . '/template/component/');
        parent::__construct();
    }
}
