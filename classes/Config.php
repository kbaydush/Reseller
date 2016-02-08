<?php

use kbaydush\Registry;

class Config extends Abstract_DataValue
{
    /** @var  string */
    protected $rootDirectory;
    /** @var  Registry */
    protected $registry;
    /** @var  string */
    protected $logDirectory;
    /** @var  Config_Mail */
    protected $mailFrom;
    /** @var  Config_Mail */
    protected $mailTest;
    /** @var  Config_PDF */
    protected $pdf;

    /**
     * Config constructor.
     * @param $rootDir
     */
    public function __construct($rootDir)
    {
        $this->rootDirectory = $rootDir;
    }

    /**
     * @return string
     */
    public function getRootDirectory()
    {
        return $this->rootDirectory;
    }

    /**
     * @param Registry $registry
     * @return Config
     */
    public function setRegistry(Registry $registry)
    {
        $this->registry = $registry;
        return $this;
    }

    /**
     * @return Registry
     */
    public function getRegistry()
    {
        return $this->registry;
    }

    /**
     * @param $logSubDir
     * @return Config
     */
    public function setLogDirectory($logSubDir)
    {
        $this->logDirectory = $this->getRootDirectory() . DIRECTORY_SEPARATOR . $logSubDir . DIRECTORY_SEPARATOR;
        return $this;
    }

    /**
     * @return string
     */
    public function getLogDirectory()
    {
        return $this->logDirectory;
    }

    /**
     * @param Config_Mail $mail
     * @return Config
     */
    public function setMailFrom(Config_Mail $mail)
    {
        $this->mailFrom = $mail;
        return $this;
    }

    /**
     * @return Config_Mail
     */
    public function getMailFrom()
    {
        return $this->mailFrom;
    }

    /**
     * @param Config_Mail $mail
     * @return Config
     */
    public function setMailTest(Config_Mail $mail)
    {
        $this->mailTest = $mail;
        return $this;
    }

    /**
     * @return Config_Mail
     */
    public function getMailTest()
    {
        return $this->mailTest;
    }

    /**
     * @param Config_PDF $PDF
     * @return Config
     */
    public function setPDF(Config_PDF $PDF)
    {
        $this->pdf = $PDF;
        return $this;
    }

    /**
     * @return Config_PDF
     */
    public function getPdf()
    {
        return $this->pdf;
    }
}
