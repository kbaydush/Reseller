<?php
// running:  php -f sync.php cron

require_once dirname(__FILE__) . "/bootstrap.php";

$argv[1] = 'purchases';
if (isset($argv[1])) {

    \reseller\HandlerFabric::handle($argv[1], $config)
        ->action();

} else {

    throw new \InvalidArgumentException("need one parameter to run ( one, two, cron )");
}
