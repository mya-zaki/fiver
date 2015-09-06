<?php

function redirect301($location)
{
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
}

function redirect302($location)
{
    header('HTTP/1.1 302 Moved Temporary');
    header('Location: ' . $location);
}

function dd($expression = null)
{
    if (!isset($expression)) {
        $debug = debug_backtrace();
        $expression = $debug[0];
    }
    var_dump($expression);
    exit;
}
