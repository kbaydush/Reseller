<?php
/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */


namespace DataValue\Mail;


class MailParamsTest extends \PHPUnit_Framework_TestCase
{

    const EXPECTED_VALUE = "1";

    public function testUrl()
    {
        $this->assertEquals(self::EXPECTED_VALUE, (new \Mail_Params())->setUrl(self::EXPECTED_VALUE)->getUrl());
    }

    public function testOrderProductNames()
    {
        $this->assertEquals(self::EXPECTED_VALUE, (new \Mail_Params())->setOrderProductNames(self::EXPECTED_VALUE)->getOrderProductNames());
    }

    public function testLicenseKey()
    {
        $this->assertEquals(self::EXPECTED_VALUE, (new \Mail_Params())->setLicenseKey(self::EXPECTED_VALUE)->getLicenseKey());
    }

    public function testCustomerFirstName()
    {
        $this->assertEquals(self::EXPECTED_VALUE, (new \Mail_Params())->setCustomerFirstName(self::EXPECTED_VALUE)->getCustomerFirstName());
    }

    public function testCustomerLastName()
    {
        $this->assertEquals(self::EXPECTED_VALUE, (new \Mail_Params())->setCustomerLastName(self::EXPECTED_VALUE)->getCustomerLastName());
    }

}
