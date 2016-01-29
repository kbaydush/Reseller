<?php

abstract class Action_Abstract
{

    /** @var Logger_Interface */
    protected $logger;
    /** @var HandlerRequest */
    protected $Request;
    /** @var HandlerRequest */
    protected static $Action;

    /**
     * Handler_Abstract constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        // set path and name of the log file (optionally)
        $this->logger = new Logging($config->getLogDirectory() . 'query.log');

        $this->Request = new Request_Params();
        $this->Request->setConfig($config);


    }
}

?>