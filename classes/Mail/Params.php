<?php

class Mail_Params extends Abstract_DataValue
{
    /** @var  string */
    protected $OrderProductNames;
    /** @var  string */
    protected $LicenseKey;
    /** @var  string */
    protected $CustomerFirstName;
    /** @var  string */
    protected $CustomerLastName;
    /** @var  string */
    protected $url;

    /**
     * @return string
     */
    public function getOrderProductNames()
    {
        return $this->OrderProductNames;
    }

    /**
     * @param string $OrderProductNames
     * @return $this
     */
    public function setOrderProductNames($OrderProductNames)
    {
        $this->OrderProductNames = $OrderProductNames;
        return $this;
    }

    /**
     * @return string
     */
    public function getLicenseKey()
    {
        return $this->LicenseKey;
    }

    /**
     * @param string $LicenseKey
     * @return $this
     */
    public function setLicenseKey($LicenseKey)
    {
        $this->LicenseKey = $LicenseKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerFirstName()
    {
        return $this->CustomerFirstName;
    }

    /**
     * @param string $CustomerFirstName
     * @return $this
     */
    public function setCustomerFirstName($CustomerFirstName)
    {
        $this->CustomerFirstName = $CustomerFirstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerLastName()
    {
        return $this->CustomerLastName;
    }

    /**
     * @param string $CustomerLastName
     * @return $this
     */
    public function setCustomerLastName($CustomerLastName)
    {
        $this->CustomerLastName = $CustomerLastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }
}
