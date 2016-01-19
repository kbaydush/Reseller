<?php
// running:  php -f one_file_to_run.php cron

require_once dirname(__FILE__) . "/bootstrap.php";

if (isset($argv[1])) {
    $command = $argv[1];

    switch ($command) {
        case "one":
            $Handler = new Handler_Http($CFG, $CFG->get('all_form_id_array')['purchases']);
            $Handler->setRequestParams($_GET, $_POST);
            break;
        case "two":
            $Handler = new Handler_Http($CFG, $CFG->get('all_form_id_array')['refunds']);
            $Handler->setRequestParams($_GET, $_POST);
            break;
        case "cron":
            $Handler = new Handler_Cron($CFG, 'cron');
            break;
        default:
            throw new \InvalidArgumentException("bad parameter to run ( one, two, cron )");
    }

    $Handler->action();


} else {
    throw new \InvalidArgumentException("need one parameter to run ( one, two, cron )");
}
