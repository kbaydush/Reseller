<?php

/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */
class DataValue_Exception_BadSetter extends Exception
{
    public function __construct($message = null, $code = null, Exception $previous = null)
    {
        parent::__construct("Setter do not exist,", $code, $previous);
    }

}
