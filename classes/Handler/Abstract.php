<?php

abstract class Handler_Abstract
{

    /** @var Logger_Interface */
    protected $logger;
    /** @var HttpRequestParser */
    protected $Request;

    /**
     * Handler_Abstract constructor.
     * @param Registry $CFG
     */
    public function __construct(Registry $CFG)
    {
        // set path and name of the log file (optionally)
        $this->logger = new Logging($CFG->get('logs_dir') . 'query.log');

        $this->Request = new HandlerRequest();
        $this->Request->setConfig($CFG);
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
        } catch (Exception $e) {
            header('HTTP/1.1 400 BAD_REQUEST');
            $this->logger->logError($e->getMessage());
            die();
        }

        return $this;
    }

    abstract public function action();
}
