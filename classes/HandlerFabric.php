<?php

/**
 * Created by PhpStorm.
 * User: wert2all
 * Date: 1/19/16
 * Time: 3:36 PM
 */
class HandlerFabric
{

    /**
     * @param $command
     * @param Registry $config
     * @return Handler_Abstract
     */
    public static function handle($command, Registry $config)
    {
        switch ($command) {
            case "one":
                $Handler = new Handler_Http($config, $config->get('all_form_id_array')['purchases']);
                $Handler->setRequestParams($_GET, $_POST);
                break;
            case "two":
                $Handler = new Handler_Http($config, $config->get('all_form_id_array')['refunds']);
                $Handler->setRequestParams($_GET, $_POST);
                break;
            case "cron":
                $Handler = new Handler_Cron($config, 'cron');
                break;
            default:
                throw new \InvalidArgumentException("bad parameter to run ( one, two, cron )");
        }

        return $Handler;

    }
}
