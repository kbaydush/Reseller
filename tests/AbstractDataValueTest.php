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
        $obj->testMethod();
    }

    /** @expectedException  DataValue_Exception_SetterOneArgument */
    public function testSetterNullArgumentsException()
    {
        $obj = new Mail_ParamDataValue();
        $obj->setOrderProductNames();
    }

    /** @expectedException  DataValue_Exception_SetterOneArgument */
    public function testSetterMoreOneArgumentsException()
    {
        $obj = new Mail_ParamDataValue();
        $obj->setOrderProductNames("1", "2");
    }

    /** @expectedException  DataValue_Exception_GetterWithoutArguments */
    public function testGetterNotNUllArgumentsException()
    {
        $obj = new Mail_ParamDataValue();
        $obj->getOrderProductNames("1");
    }

    /** @expectedException  DataValue_Exception_BadGetter */
    public function testBadGetterException()
    {
        $obj = new Mail_ParamDataValue();
        $obj->getException();
    }

    /** @expectedException  DataValue_Exception_BadSetter */
    public function testBadSetterException()
    {
        $obj = new Mail_ParamDataValue();
        $obj->setException("S");
    }
}
