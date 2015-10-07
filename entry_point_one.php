<?php

    require_once dirname(__FILE__)."/config.php";

    $controller = new Controller($CFG, $CFG->all_form_id_array['purchases']);

    $controller->setRequestParams($_GET, $_POST);

    $controller->action();


?>