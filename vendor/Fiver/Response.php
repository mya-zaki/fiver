<?php

class Fiver_Response
{
    /** @var Fiver_Response self obj */
    private static $instance = null;
    
    /** @var array list => string $string [, bool $replace = true] */
    private $header_list = array();
    
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            $class_name = get_class();
            self::$instance = new $class_name();
        }
        
        return self::$instance;
    }
    
    private function __construct()
    {
    }
    
    public function setHeader($string, $replace = true)
    {
        $this->header_list[] = array(
            'string'  => $string,
            'replace' => $replace,
        );
    }
    
    public function getHeaders()
    {
        return $this->header_list;
    }
    
    public function sendHeaders()
    {
        foreach ($this->header_list as $header) {
            header($header['string'], $header['replace']);
        }
    }
}
