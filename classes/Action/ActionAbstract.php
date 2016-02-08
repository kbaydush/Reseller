<?php
namespace reseller\Action;

use reseller\Config;
use reseller\Logging;
use reseller\Request\Params;

abstract class ActionAbstract
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

    }

    public function setRequestData(Params $request)
    {
        $this->Request = $request;
        return $this;
    }

    public function getParams()
    {
        return $this->Request->getParams();

    }


    public function getStorage()
    {
        return $this->Request->loadStorage();
    }
}

?>