<?php

class Fiver_RouteTest extends PHPUnit_Framework_TestCase
{
    
    /**
     * test match
     */
    public function testMatch()
    {
        $rules = array(
            0 => array(
                '/test/test/:id', // pattern
                array('module' => 'test', 'action' => 'test', 'id' => '0123456789'), // params
                array('id' => '\d+') // requirements
            ),
            1 => array(
                '/:module/:action', // pattern
                array('module' => 'index', 'action' => 'index'), // params
            ),
        );

        $url = "/test/test/9999";
        $expect = array(
            'module' => 'test',
            'action' => 'test',
            'id'     => '9999',
        );
        $fivroute = new Fiver_Route($url, $rules);
        $this->assertSame($expect, $fivroute->match());
        
        $url = "/test/test/xxxx";
        $expect = array(
            'module' => 'test',
            'action' => 'test',
        );
        $fivroute = new Fiver_Route($url, $rules);
        $fivroute->match();
        
        $url = "/test/test";
        $expect = array(
            'module' => 'test',
            'action' => 'test',
            'id'     => '0123456789',
        );
        $fivroute = new Fiver_Route($url, $rules);
        $fivroute->match();
        
        $url = "/testmodule/testaction/";
        $expect = array(
            'module' => 'testmodule',
            'action' => 'testaction',
        );
        $fivroute = new Fiver_Route($url, $rules);
        $fivroute->match();
        
        $url = "/testmodule";
        $expect = array(
            'module' => 'testmodule',
            'action' => 'index',
        );
        $fivroute = new Fiver_Route($url, $rules);
        $fivroute->match();
        
        $url = "/";
        $expect = array(
            'module' => 'index',
            'action' => 'index',
        );
        $fivroute = new Fiver_Route($url, $rules);
        $fivroute->match();
    }
}