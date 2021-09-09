<?php
const ROOT_DIR = __DIR__;
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors','on');
ini_set('error_log', __DIR__ . '/logs/main_error.log');
require_once 'engine/bootsrap.php';