<?php
/**
 * Created by PhpStorm.
 * User: k.baidush
 */


// init autoloader
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', true);
date_default_timezone_set('UTC');

require_once(dirname(__FILE__) . '/classes/Autoloader/Interface.php');
require_once(dirname(__FILE__) . '/classes/Autoloader.php');

$loader = new Autoloader();
$loader->setRootPath(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "classes" . DIRECTORY_SEPARATOR));

Autoloader::register($loader);

require_once(dirname(__FILE__) . "/config.ini.php");