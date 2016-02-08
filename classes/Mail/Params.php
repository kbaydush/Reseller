<?php
namespace reseller\Mail;

use reseller\DataValue\AbstractDataValue;
use reseller\DataValue\Property;
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
class Params extends AbstractDataValue
{

    /**
     * @return array
     */
    public function _getInitPropertyList()
    {
        return array(
            (new Property("OrderProductNames"))->setRequired(),
            (new Property("LicenseKey"))->setRequired(),
            (new Property("CustomerFirstName"))->setRequired(),
            (new Property("CustomerLastName"))->setRequired(),
            (new Property("url"))->setRequired()
        );
    }
}
