<?php

/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */
class DataValue_Exception_SetterOneArgument extends Exception
{
    public function __construct($message = null, $code = null, Exception $previous = null)
    {
        parent::__construct("Setter can use only one argument", $code, $previous);
    }

}
