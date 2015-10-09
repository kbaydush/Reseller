<?php

/*
 * PHP Class Logging
 * Created by K.Baidush
 * Write log files
 */

class Logging implements Logger_Interface
{

    const INFO_PREFIX = "INFO";
    const ERROR_PREFIX = "ERROR";

    /** @var  string */
    protected $log_file;
    /** @var  Logger_Row [] */
    protected $messages = array();

    /**
     * Logging constructor.
     * @param $log_file
     */
    public function __construct($log_file)
    {
        $this->log_file = $log_file;
    }

    public function __destruct()
    {
        $massages = $this->generateFullLogMessage();
        file_put_contents($this->log_file, $massages, FILE_APPEND);
    }

    /**
     * @return string
     */
    protected function generateFullLogMessage()
    {
        $returnString = "";
        if (count($this->messages) > 0) {
            $returnString .= "BEGIN: \n";
            foreach ($this->messages as $message) {
                /** @var Logger_Row $message */
                $returnString .= $message->__toString();
            }
            $returnString .= "END\n";
        }

        return $returnString;
    }

    /**
     * @param string $message
     * @return void
     */
    public function logError($message)
    {
        $this->appendMessage(self::ERROR_PREFIX, $message);
    }

    /**
     * @param string $prefix
     * @param string $message
     */
    protected function appendMessage($prefix, $message)
    {
        $this->messages[] = new Logger_Row($prefix, $message);
    }

    /**
     * @param string $message
     * @return void
     */
    public function logInfo($message)
    {
        $this->appendMessage(self::INFO_PREFIX, $message);
    }

}
