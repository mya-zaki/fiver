<?php

// for DEV
ini_set('display_errors', 'On');

// config
require_once APP . '/config/define.php';
require_once APP . '/config/config.php';

// log setting
Logger::configure(APP . '/config/log_config.xml'); // 設定ファイルの読み込み
$logger = Logger::getLogger('myLogger');

$logger->info("info message");
$logger->debug("debug message");
