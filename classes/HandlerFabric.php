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
     * @param string $command
     * @param Registry $config
     * @return Handler_Abstract
     */
    public static function handle($command, Registry $config)
    {
        switch ($command) {
            case "one":
                $Handler = new Handler_Http($config);
                break;
            case "two":
                $Handler = new Handler_Http($config);
                break;
            case "cron":
                $Handler = new Handler_Cron($config);
                break;
            default:
                throw new \InvalidArgumentException("bad parameter to run ( one, two, cron )");
        }

        return $Handler->setRequestParams(self::getRequest())
            ->setProcessFormID(
                self::getProcessFormId($command, $config)
            );
    }

    /**
     * @return array
     */
    private static function getRequest()
    {
        $return = array();
        if (isset($_POST) and count($_POST) > 0) {
            $return = $_POST;
        } else if (isset($_GET) and count($_GET) > 0) {
            $return = $_GET;
        }

        return $return;
    }

    /**
     * @param string $command
     * @param Registry $config
     * @return string
     */
    private static function getProcessFormId($command, Registry $config)
    {
        switch ($command) {
            case "one":
                return $config->get('all_form_id_array')['purchases'];
                break;
            case "two":
                return $config->get('all_form_id_array')['refunds'];
                break;
            default:
                return Handler_Cron::PROCESS_FORM;
        }
    }
}
