<?php


/**
 * @method string getFilePath()
 * @method Mail_Attachment setFilePath(string $value)
 */
class Mail_Attachment extends DataValue_AbstractDataValue
{

    /**
     * @return array
     */
    public function _getInitPropertyList()
    {
        return array(
            (new DataValue_Property("filePath"))
                ->setReadOnly()
                ->setRequired()
        );
    }
}
