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

            case "cron":
                $Handler = new Handler_Cron($config);
                break;
            default:
                $Handler = new Handler_Http($config);

        }

        return $Handler->setProcessFormID(self::getProcessFormId($command, $config))
            ->setRequestParams(self::getRequest());
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

        if (isset($config->get('all_form_id_array')[$command])) {
            return $config->get('all_form_id_array')[$command];
        } else {
            throw new \InvalidArgumentException("wrong command name parameter");
        }

    }
}
