<?php
define('ROOT_DIR', dirname(__DIR__));

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'on');
ini_set('error_log', ROOT_DIR . '/tmp/logs/main_error.log');

require_once ROOT_DIR . '/engine/bootsrap.php';
