<?php
namespace reseller\Handler;
use reseller\Logging;
use reseller\Config;
use reseller\Request\Params;
abstract class HandlerAbstract
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

        $this->Request = new Params();
        $this->Request->setConfig($config);

    }

    /**
     * @param $formID
     * @return $this
     */
    public function setProcessFormID($formID)
    {
        $this->Request->setProcessFormId($formID);
        return $this;
    }

    /**
     * @param $command
     * @return $this
     */
    public function setCommand($command)
    {
        $this->Request->setCommand($command);
        return $this;
    }


    public function __destruct()
    {
        unset($this->logger);

        echo "Done.";
    }

    /**
     * @param array $request
     * @return $this
     */
    public function setRequestParams(array $request)
    {
        try {
            if (count($request) > 0) {
                $this->Request->setParams($request);
            } else {
                throw new \InvalidArgumentException("Required params are absent!");
            }
        } catch (\Exception $e) {
            header('HTTP/1.1 400 BAD_REQUEST');
            $this->logger->logError($e->getMessage());
            die();
        }

        return $this;
    }

    abstract public function action();
}
