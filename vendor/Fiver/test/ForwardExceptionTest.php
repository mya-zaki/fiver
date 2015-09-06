<?php

class Fiver_ForwardExceptionTest extends PHPUnit_Framework_TestCase
{
    /**
     * test object
     */
    public function testGet()
    {
        $fivfwdex = new Fiver_ForwardException('test_module', 'test_action');
    
        $this->assertSame('test_module', $fivfwdex->getModuleName());
        $this->assertSame('test_action', $fivfwdex->getActionName());
    }
}
