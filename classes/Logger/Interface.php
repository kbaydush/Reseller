<?php

/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */
interface Logger_Interface
{
    /**
     * @param string $message
     * @return void
     */
    public function logInfo($message);

    /**
     * @param string $message
     * @return void
     */
    public function logError($message);
}
