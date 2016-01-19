<?php
// running:  php -f one_file_to_run.php cron

require_once dirname(__FILE__) . "/bootstrap.php";

if (isset($argv[1])) {
    $command = $argv[1];

    switch ($command) {
        case "one":
            $Handler = new Handler($CFG, $CFG->get('all_form_id_array')['purchases']);
            $Handler->setRequestParams($_GET, $_POST)
                ->action();
            break;
        case "two":
            $Handler = new Handler($CFG, $CFG->get('all_form_id_array')['refunds']);
            $Handler->setRequestParams($_GET, $_POST)
                ->action();
            break;
        case "cron":
            $Handler = new Handler($CFG, 'cron');
            $Handler->setRequestParams($_GET, $_POST)
                ->actionCron();
            break;
        default:
            throw new \InvalidArgumentException("bad parameter to run ( one, two, cron )");
    }
} else {
    throw new \InvalidArgumentException("need one parameter to run ( one, two, cron )");
}
