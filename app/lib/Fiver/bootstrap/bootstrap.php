<?php

define('FIVER_VERSION', '0.1.0');

//base path
define('APP', dirname(dirname(dirname(dirname(realpath(__FILE__))))));
define('ROOT', APP . '/..');
define('VENDOR', ROOT . '/vendor');
define('STORAGE', ROOT . '/storage');

// include path
addIncludePath(VENDOR);
addIncludePath(APP . '/action');
addIncludePath(APP . '/lib');

// autoload
require_once dirname(realpath(__FILE__)) . '/autoload.php';

// helper
require_once dirname(realpath(__FILE__)) . '/../helper/functions.php';

// bootstrap
require_once APP . '/bootstrap/bootstrap.php';

// config
require_once APP . '/config/define.php';
require_once APP . '/config/config.php';

function addIncludePath($new_include_path)
{
    $current_include_path = get_include_path();
    if (!in_array($new_include_path, explode(PATH_SEPARATOR, $current_include_path))) {
        set_include_path($new_include_path . PATH_SEPARATOR . $current_include_path);
    }
}
