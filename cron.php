<?php
    require_once dirname(__FILE__)."/config.php";

    $Handler = new Handler($CFG, 'cron');

    $Handler->setRequestParams($_GET, $_POST);

    $Handler->actionCron();
?>