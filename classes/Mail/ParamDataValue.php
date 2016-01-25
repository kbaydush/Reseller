<?php

/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */

/**
 *
 * @method Mail_ParamDataValue setUrl(string $value)
 * @method string getUrl()
 */
class Mail_ParamDataValue extends DataValue_AbstractDataValue
{

    protected function _initFields()
    {
        $this->addProperty("url", 1);
    }
}
