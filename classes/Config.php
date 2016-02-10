<?php
namespace reseller;


use reseller\Config\ConfigMail;
use reseller\Config\ConfigPDF;

class Config extends Abstract_DataValue
{
    /** @var  string */
    protected $rootDirectory;
    /** @var  Registry */
    protected $registry;
    /** @var  string */
    protected $logDirectory;
    /** @var  ConfigMail */
    protected $mailFrom;
    /** @var  ConfigMail */
    protected $mailTest;
    /** @var  ConfigPDF */
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
     * @param ConfigMail $mail
     * @return Config
     */
    public function setMailFrom(ConfigMail $mail)
    {
        $this->mailFrom = $mail;
        return $this;
    }

    /**
     * @return ConfigMail
     */
    public function getMailFrom()
    {
        return $this->mailFrom;
    }

    /**
     * @param ConfigMail $mail
     * @return Config
     */
    public function setMailTest(ConfigMail $mail)
    {
        $this->mailTest = $mail;
        return $this;
    }

    /**
     * @return ConfigMail
     */
    public function getMailTest()
    {
        return $this->mailTest;
    }

    /**
     * @param ConfigPDF $PDF
     * @return Config
     */
    public function setPDF(ConfigPDF $PDF)
    {
        $this->pdf = $PDF;
        return $this;
    }

    /**
     * @return ConfigPDF
     */
    public function getPdf()
    {
        return $this->pdf;
    }
    
}
