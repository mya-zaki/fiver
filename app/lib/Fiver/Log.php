<?php
/**
 * Fiver Logger
 *   log4php wrapper
 * 
 * e.g.
 *   Fiver_Log::info("log message1", array("log message2", "log message3"), "log message4");
 *   -> INFO 2015-03-30 18:20:43 log message1	log message2	log message3	log message4	/fiver/app/action/Sample/IndexAction.php:10
 */


class Fiver_Log
{
    const DEFAULT_CATEGORY_NAME = 'fiver';
    const LOG_DELIMITER         = "\t";
    
    private static $marker = array();
    
    /**
     * Get time as micro second
     *
     * @return array micro second
     */
    public static function utime() {
        return explode(' ',microtime());
    }
    /**
     * Get difference between the micro second objects
     *
     * @param array $t1  Micro second object
     * @param array $t2  Micro second object
     * @return int difference as micro second
     */
    public static function diffutime($t1, $t2) {
        return (($t1[0] - $t2[0]) + ($t1[1] - $t2[1])) * 1000000;
    }
    
    /**
     * marking a start time
     * 
     * @param string $name marking name
     */
    public static function mark($name)
    {
        self::$marker[$name] = self::utime();
    }
    
    /**
     * performance log
     * level info
     *   
     * @param string $name marking name
     * @param string $message log message
     */
    public static function performance($name, $message)
    {
        if (isset(self::$marker[$name])) {
            $debug = debug_backtrace();
            $logger = Logger::getLogger(self::DEFAULT_CATEGORY_NAME);
            $now = self::utime();
            $diff = self::diffutime($now, self::$marker[$name]);
            $performance = sprintf('%4.3f (msec) %4.3f (KB) ', $diff/1000, (memory_get_usage(true)/1000));
            $message = self::implode_recursive(self::LOG_DELIMITER, array("PERFORMANCE[$name]", $performance, $message, $debug[0]['file'].':'.$debug[0]['line']));
            $logger->info($message);
        }
    }
    
    /**
     * level debug
     *
     * @param string ...$args
     */
    public static function debug()
    {
        $debug = debug_backtrace();
        $logger = Logger::getLogger(self::DEFAULT_CATEGORY_NAME);
        $args = func_get_args();
        array_push($args, $debug[0]['file'].':'.$debug[0]['line']);
        $message = self::implode_recursive(self::LOG_DELIMITER, $args);
        $logger->debug($message);
    }
    
    /**
     * level info
     *
     * @param string ...$args
     */
    public static function info()
    {
        $debug = debug_backtrace();
        $logger = Logger::getLogger(self::DEFAULT_CATEGORY_NAME);
        $args = func_get_args();
        array_push($args, $debug[0]['file'].':'.$debug[0]['line']);
        $message = self::implode_recursive(self::LOG_DELIMITER, $args);
        $logger->info($message);
    }
    
    /**
     * level warn
     *
     * @param string ...$args
     */
    public static function warn()
    {
        $debug = debug_backtrace();
        $logger = Logger::getLogger(self::DEFAULT_CATEGORY_NAME);
        $args = func_get_args();
        array_push($args, $debug[0]['file'].':'.$debug[0]['line']);
        $message = self::implode_recursive(self::LOG_DELIMITER, $args);
        $logger->warn($message);
    }
    
    /**
     * level error
     *
     * @param string ...$args
     */
    public static function error()
    {
        $debug = debug_backtrace();
        $logger = Logger::getLogger(self::DEFAULT_CATEGORY_NAME);
        $args = func_get_args();
        array_push($args, $debug[0]['file'].':'.$debug[0]['line']);
        $message = self::implode_recursive(self::LOG_DELIMITER, $args);
        $logger->error($message);
    }
    
    /**
     * level fatal
     *
     * @param string ...$args
     */
    public static function fatal()
    {
        $debug = debug_backtrace();
        $logger = Logger::getLogger(self::DEFAULT_CATEGORY_NAME);
        $args = func_get_args();
        array_push($args, $debug[0]['file'].':'.$debug[0]['line']);
        $message = self::implode_recursive(self::LOG_DELIMITER, $args);
        $logger->fatal($message);
    }
    
    /**
     * array2str
     * 
     * @param string $glue
     * @param array $pieces
     * @return string
     */
    private static function implode_recursive($glue, $pieces)
    {
        return implode($glue, self::array_flatten($pieces));
    }
    
    /**
     * array flatten
     * @param array $array
     * @return array
     */
    private static function array_flatten($array)
    {
        $ret = array();
        array_walk_recursive($array, array('self', 'array_push'), array(&$ret));
        return $ret;
    }
    
    /**
     * array_push4callbacking
     * 
     * @param mixed $value
     * @param int $key
     * @param array $array
     */
    private static function array_push($value, $key, &$array)
    {
        array_push($array[0], $value);
    }
}


// 