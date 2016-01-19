<?php
// running:  php -f sync.php cron

require_once dirname(__FILE__) . "/bootstrap.php";

if (isset($argv[1])) {

    HandlerFabric::handle($argv[1], $CFG)
        ->action();

} else {
    throw new \InvalidArgumentException("need one parameter to run ( one, two, cron )");
}
