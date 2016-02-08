<?php
namespace reseller\Mail;

use reseller\DataValue\AbstractDataValue;
use reseller\DataValue\Property;

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
            (new Property("filePath"))
//                ->setReadOnly()
                ->setRequired()
                ->setValue('files')
        );
    }
}
