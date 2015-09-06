<?php

class Fiver_InputTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $_GET['test']        = 'Test';
        $_GET['testmethod']  = 'Get';
        $_POST['testmethod'] = 'Post';
    }
    
    
    public function testGet()
    {
        $input = new Fiver_Input();
        $input->get('test');
        
        $this->assertSame('Test', $input->get('test'));
        $this->assertSame('Test', $input->get('test', 'default'));
        $this->assertSame('NotExist', $input->get('notexist', 'NotExist'));
        $this->assertSame('Post', $input->get('testmethod'));
    }
    
}
