<?php
//base path
if(!defined('APP')){
    define('APP', dirname(dirname(dirname(dirname(realpath(__FILE__))))) . '/app');
}
if(!defined('ROOT')){
    define('ROOT', APP . '/..');
}
if(!defined('VENDOR')){
    define('VENDOR', ROOT . '/vendor');
}
if(!defined('STORAGE')){
    define('STORAGE', ROOT . '/storage');
}

// include path
addIncludePath(VENDOR);
addIncludePath(APP . '/action');
addIncludePath(APP . '/lib');

// logger
require_once('log4php/Logger.php');

// autoload
require_once dirname(realpath(__FILE__)) . '/autoload.php';

// log setting
Logger::configure(APP . '/config/logger_config.xml'); // 設定ファイルの読み込み

// helper
require_once dirname(realpath(__FILE__)) . '/../helper/functions.php';

// user config
require_once APP . '/config/define.php';
require_once APP . '/config/config.php';

// bootstrap
require_once APP . '/bootstrap/bootstrap.php';

function addIncludePath($new_include_path)
{
    $current_include_path = get_include_path();
    if (!in_array($new_include_path, explode(PATH_SEPARATOR, $current_include_path))) {
        set_include_path($new_include_path . PATH_SEPARATOR . $current_include_path);
    }
}
