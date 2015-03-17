<?php

function redirect301($location)
{
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}

function redirect302($location)
{
    header('HTTP/1.1 302 Moved Temporary');
    header('Location: ' . $location);
    exit;
}

function dd($expression = null)
{
    if (!isset($expression)) {
        $expression = debug_backtrace();
    }
    var_dump($expression);
    exit;
}
