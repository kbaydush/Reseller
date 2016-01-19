<?php

abstract class Handler_Abstract
{

    /** @var Logger_Interface */
    protected $error_log;
    /** @var Logger_Interface */
    protected $query_log;
    /** @var HttpRequestParser */
    protected $Request;

    public function __construct($CFG, $formId)
    {

// Set real formId

        $CFG->set('processFormId', $formId);

// set path and name of the log file (optionally)
        $this->error_log = new Logging($CFG->get('logs_dir') . 'error.log');
        $this->query_log = new Logging($CFG->get('logs_dir') . 'query.log');

        try {
            $this->Request = new HttpRequestParser();

            if (empty($CFG) || !isset($CFG)) {
                throw new \InvalidArgumentException("Bootstrap failed!");

            } else {
                $this->Request->setConfig($CFG);
            }

        } catch (Exception $e) {
            header('HTTP/1.1 400 BAD_REQUEST');
            $this->error_log->logError($e->getMessage());
            die();
        }
    }

    public function __destruct()
    {
        unset($this->query_log);
        unset($this->error_log);

        echo "Done.";
    }

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
            $this->error_log->logError($e->getMessage());
            die();
        }

        return $this;
    }

    abstract public function action();
}
