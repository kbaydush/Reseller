<?php

/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */
namespace Tests\DataValue;

use DataValue_AbstractDataValue;
use DataValue_Exception_GetterWithoutArguments;
use DataValue_Exception_NotSetterNotGetter;
use DataValue_Exception_Property_Bad;
use DataValue_Exception_SetterOneArgument;

class AbstractTest extends \PHPUnit_Framework_TestCase
{
    /** @var  DataValue_AbstractDataValue */
    protected $param;

    /** @expectedException DataValue_Exception_NotSetterNotGetter */
    public function testBadMethod()
    {
        $this->param->tesUrl();
    }

    /** @expectedException  DataValue_Exception_SetterOneArgument */
    public function testSetterNullArgumentsException()
    {
        $this->param->setUrl();
    }

    /** @expectedException  DataValue_Exception_SetterOneArgument */
    public function testSetterMoreOneArgumentsException()
    {
        $this->param->setUrl("1", "2");
    }

    /** @expectedException  DataValue_Exception_GetterWithoutArguments */
    public function testGetterNotNUllArgumentsException()
    {
        $this->param->getUrl("1");
    }

    /** @expectedException  DataValue_Exception_Property_Bad */
    public function testBadGetterException()
    {
        $this->param->getException();
    }

    /** @expectedException  DataValue_Exception_Property_Bad */
    public function testBadSetterException()
    {
        $this->param->setException("S");
    }

    /**
     * Test upper case of getter
     *
     */
    public function testGetterUpperCase()
    {
        $this->param->setUrl("s");
        $this->param->getUrl();
        $this->param->geturl();
        $this->param->Geturl();
        $this->param->GetUrl();
    }

    /**
     * Test upper case of setter
     *
     */
    public function testSetterUpperCase()
    {
        $this->param->setUrl("1");
        $this->param->seturl("1");
        $this->param->Seturl("1");
        $this->param->SetUrl("1");
    }

    public function testSetterReturn()
    {
        $this->assertInstanceOf("DataValue_AbstractDataValue", $this->param->setUrl("1"));
    }


    public function testGetter()
    {
        $this->assertEquals(
            "test value",
            $this->param->setUrl("test value")
                ->getUrl()
        );
    }

    protected function setUp()
    {
        parent::setUp();

        $mock = $this->getMockBuilder('DataValue_AbstractDataValue')
            ->setConstructorArgs(array(
                array(
                    new \DataValue_Property("url")
                )
            ))
            ->getMock();

        $this->param = $mock;
    }

}
