<?php

/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */
class AbstractDataValueTest extends PHPUnit_Framework_TestCase
{


//    public function testSetter()
//    {
//        $value = "1";
//        $dataValue = new Mail_ParamDataValue();
//        $dataValue->setOrderProductNames($value);
//        $this->assertEquals($value, $dataValue->getOrderProductNames());
//    }

    /** @expectedException DataValue_Exception_NotSetterNotGetter */
    public function testBadMethod()
    {
        $obj = new Mail_ParamDataValue();
        $obj->tesUrl();
    }

    /** @expectedException  DataValue_Exception_SetterOneArgument */
    public function testSetterNullArgumentsException()
    {
        $obj = new Mail_ParamDataValue();
        $obj->setUrl();
    }

    /** @expectedException  DataValue_Exception_SetterOneArgument */
    public function testSetterMoreOneArgumentsException()
    {
        $obj = new Mail_ParamDataValue();
        $obj->setUrl("1", "2");
    }

    /** @expectedException  DataValue_Exception_GetterWithoutArguments */
    public function testGetterNotNUllArgumentsException()
    {
        $obj = new Mail_ParamDataValue();
        $obj->getUrl("1");
    }

    /** @expectedException  DataValue_Exception_BadProperty */
    public function testBadGetterException()
    {
        $obj = new Mail_ParamDataValue();
        $obj->getException();
    }

    /** @expectedException  DataValue_Exception_BadProperty */
    public function testBadSetterException()
    {
        $obj = new Mail_ParamDataValue();
        $obj->setException("S");
    }

    /**
     * Test upper case of getter
     *
     */
    public function testGetterUpperCase()
    {
        $obj = new Mail_ParamDataValue();

        $obj->getUrl();
        $obj->geturl();
        $obj->Geturl();
        $obj->GetUrl();
    }

    /**
     * Test upper case of setter
     *
     */
    public function testSetterUpperCase()
    {
        $obj = new Mail_ParamDataValue();

        $obj->setUrl("1");
        $obj->seturl("1");
        $obj->Seturl("1");
        $obj->SetUrl("1");
    }

}
