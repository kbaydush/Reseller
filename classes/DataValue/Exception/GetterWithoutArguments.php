<?php

/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */
class DataValue_Exception_GetterWithoutArguments extends Exception
{
    public function __construct($message = null, $code = null, Exception $previous = null)
    {
        parent::__construct("Getter can not have arguments", $code, $previous);
    }

}
