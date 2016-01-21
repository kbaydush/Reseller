<?php


class Mail_Attachment extends Abstract_DataValue
{
    /** @var  string */
    protected $filePath;

    /**
     * Mail_Attachment constructor.
     * @param string $filePath
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @return string
     */
    public function getFilePath()
    {
        return $this->filePath;
    }
}
