<?php


/**
 * @method string getFilePath()
 * @method Mail_Attachment setFilePath(string $value)
 */
class Mail_Attachment extends DataValue_AbstractDataValue
{

    /**
     * @return void
     */
    protected function _initFields()
    {
        $this->addProperty('filePath', (new DataValue_Property())->setReadOnly());
    }
}
