<?php

class Fiver_DispatcherTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // check xdebug installed
        if (!extension_loaded('xdebug')) {
            $this->markTestSkipped('Cannot use xdebug expansion module.');
        }
    }
    
    /**
     * test dispatch
     *   action not found
     * 
     * @runInSeparateProcess
     */
//     public function testDispatch404()
//     {
//         ob_start();
//         Fiver_Dispatcher::dispatch('nomodule', 'noaction');
//         ob_end_clean();
        
//         $headers = Fiver_Response::getInstance()->getHeaders();
//         $this->assertSame('HTTP/1.1 404 Not Found', $headers[0]['string']);
//     }
    
    /**
     * test dispatch
     *   forward to test2 action from test1 action
     * 
     * @runInSeparateProcess
     */
    public function testDispatchForward()
    {
        addIncludePath(APP . '/lib/Fiver/test/action');
        
        ob_start();
        Fiver_Dispatcher::dispatch('fivertest', 'dispatch1');
        $buffer = ob_get_clean();
    
//         $this->assertSame('HTTP/1.1 404 Not Found', $buffer);
    }
}
