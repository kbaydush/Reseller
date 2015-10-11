<?php
require_once dirname(__FILE__) . "/init.php";

    $Handler = new Handler($CFG, 'cron');

    $Handler->setRequestParams($_GET, $_POST);

    $Handler->actionCron();
?>