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
     * @return array
     */
    public function _getInitPropertyList()
    {
        return array(
            (new DataValue_Property("OrderProductNames"))->setRequired(),
            (new DataValue_Property("LicenseKey"))->setRequired(),
            (new DataValue_Property("CustomerFirstName"))->setRequired(),
            (new DataValue_Property("CustomerLastName"))->setRequired(),
            (new DataValue_Property("url"))->setRequired()
        );
    }
}
