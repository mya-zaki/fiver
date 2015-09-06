<?php

class Fiver_ContainerTest extends PHPUnit_Framework_TestCase
{
    /**
     * test get
     */
    public function testGet()
    {
        $fivc = new Fiver_Container();
        
        $fivc->set('test', 'Test');
        
        $this->assertSame('Test', $fivc->get('test'));
        $this->assertNull($fivc->get('notexist'));
        $this->assertSame('default', $fivc->get('notexist', 'default'));
    }
}
