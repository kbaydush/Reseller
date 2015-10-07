<?php
    require_once dirname(__FILE__)."/config.php";

    $controller = new Controller($CFG, 'cron');

    $controller->setRequestParams($_GET, $_POST);

    $controller->actionCron();
?>