<?php
// bootstrap
require_once dirname(dirname(realpath(__FILE__))) . '/app/lib/Fiver/bootstrap/bootstrap.php';

Fiver_Log::mark('fiver_req');

// routing
$request_url_path = rtrim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), '/');
$rules = include_once APP . '/config/route.php';
$route = new Fiver_Route($request_url_path, $rules);
$match = $route->match();

Fiver_Dispatcher::dispatch($match['module'], $match['action']);

Fiver_Log::performance('fiver_req', '1request');
