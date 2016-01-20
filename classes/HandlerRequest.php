<?php

/**
 * {license_notice}
 *
 * @copyright   baidush.k
 * @license     {license_link}
 */
class HandlerRequest extends Request_Abstract
{
    protected $processFormId = Handler_Cron::PROCESS_FORM;


    /**
     * @param mixed $processFormId
     */
    public function setProcessFormId($processFormId)
    {
        $this->processFormId = $processFormId;
    }
}
