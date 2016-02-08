<?php
namespace reseller\Mail;

use \reseller\DataValue\AbstractDataValue;

/**
 * @method string getFilePath()
 * @method Mail_Attachment setFilePath(string $value)
 */
class Attachment extends AbstractDataValue
{

    /**
     * @return array
     */
    public function _getInitPropertyList()
    {
        return array(
            (new \reseller\DataValue\Property("files"))
                ->setReadOnly()
                ->setRequired()
                ->setValue()
        );
    }
}
