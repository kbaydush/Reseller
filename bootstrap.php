<?php
/**
 * {license_notice}
 *
 * @copyright   baidush.k
 * @license     {license_link}
 */

error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', true);
date_default_timezone_set('UTC');

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . "autoload.php";

use reseller\Registry;

$CFG = new Registry();

require_once(ROOT_DIR . "/settings/request_config.ini.php");
require_once(ROOT_DIR . "/settings/config.ini.php");

