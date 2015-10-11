<?php
/**
 * Created by PhpStorm.
 * User: k.baidush
 */


// init autoloader
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', true);
date_default_timezone_set('UTC');


require_once(dirname(__FILE__) . "/config.php");
require_once(dirname(__FILE__) . '/classes/Autoloader/Interface.php');
require_once(dirname(__FILE__) . '/classes/Autoloader.php');

$loader = new Autoloader();
$loader->setRootPath($CFG->classes_dir);

Autoloader::register($loader);