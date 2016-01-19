<?php
/**
 * {license_notice}
 *
 * @copyright   baidush.k
 * @license     {license_link}
 */

define('ROOT_DIR', dirname(__FILE__));

error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', true);
date_default_timezone_set('UTC');

// init autoloader
require_once(ROOT_DIR . '/classes/Autoloader/Interface.php');
require_once(ROOT_DIR . '/classes/Autoloader.php');
$composer_load = require_once(ROOT_DIR . '/plugins/autoload.php');

$loader = new Autoloader();
$loader->setRootPath(realpath(ROOT_DIR . DIRECTORY_SEPARATOR . "classes" . DIRECTORY_SEPARATOR));

Autoloader::register($loader);

require_once(ROOT_DIR . "/config.ini.php");
