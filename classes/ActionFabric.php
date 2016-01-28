<?php

/**
 * {license_notice}
 *
 * @copyright   baidush.k
 * @license     {license_link}
 */
class ActionFabric
{
    protected $processFormId = Handler_Cron::PROCESS_FORM;

    protected $command = Handler_Cron::PROCESS_FORM;


    /**
     * @param string $command
     * @param Config $config
     * @return Handler_Abstract
     */
    public static function handle($action_mode)
    {
        switch ($action_mode) {

            case "curl_http_request":
                $Action = new Curl();
                break;

            case "pdf_creator":
                $Action = new Pdf();
                break;

            case "mail":
                $Action = new Mail();
                break;
//
//            default:
//                $Handler = new Handler_Http($config);

        }

        return $Action;
    }

    /**
     * @param mixed $processFormId
     */
    public function setProcessFormId($processFormId)
    {
        $this->processFormId = $processFormId;
    }

    /**
     * @param mixed $command
     */
    public function setCommand($command)
    {
        $this->command = $command;
    }
}
