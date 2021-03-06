<?php
/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */

use reseller\Autoloader;
use Composer\Autoload;

define('ROOT_DIR', dirname(__FILE__));
// init autoloader
require_once(ROOT_DIR . '/classes/Autoloader/Interface.php');
require_once(ROOT_DIR . '/classes/Autoloader.php');
$composer_load = require_once(ROOT_DIR . '/plugins/autoload.php');

$loader = new Autoloader();
$loader->addNamespace("reseller", realpath(ROOT_DIR . DIRECTORY_SEPARATOR . "classes" . DIRECTORY_SEPARATOR));
$loader->register();
