<?php

/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */
class Logger_Row
{
    /** @var int */
    protected $time;
    /** @var string */
    protected $type;
    /** @var string */
    protected $message;

    /**
     * Logger_Row constructor.
     * @param string $type
     * @param string $message
     */
    public function __construct($type, $message)
    {
        $this->time = time();
        $this->type = $type;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "\t" . $this->time . " " . $this->type . ": " . $this->message . "\n";
    }

}
