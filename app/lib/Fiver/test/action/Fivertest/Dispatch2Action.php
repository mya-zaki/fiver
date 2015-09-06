<?php

class Fivertest_Test2Action extends Fiver_Action
{
    protected function main()
    {
        throw new Exception('test exception!');
    }
    
    protected function before()
    {
    }
    
    protected function after()
    {
    }
}
