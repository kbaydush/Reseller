<?php

/**
 * @method  string getOrderProductNames()
 * @method Mail_Params setOrderProductNames($value)
 * @method  string getLicenseKey()
 * @method  Mail_Params setLicenseKey ($value)
 * @method  string getCustomerFirstName()
 * @method  Mail_Params setCustomerFirstName($value)
 * @method  string getCustomerLastName()
 * @method  Mail_Params setCustomerLastName($value)
 * @method  string getUrl()
 * @method  Mail_Params setUrl($value)
 */
class Mail_Params extends DataValue_AbstractDataValue
{

    /**
     * @return void
     */
    protected function _initFields()
    {
        $this->addProperty("OrderProductNames", new DataValue_Property())
            ->addProperty("LicenseKey", new DataValue_Property())
            ->addProperty("CustomerFirstName", new DataValue_Property())
            ->addProperty("CustomerLastName", new DataValue_Property())
            ->addProperty("url", new DataValue_Property());
    }
}
