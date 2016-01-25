<?php

/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */
namespace Tests\DataValue;

use DataValue_AbstractDataValue;
use DataValue_Exception_BadProperty;
use DataValue_Exception_GetterWithoutArguments;
use DataValue_Exception_NotSetterNotGetter;
use DataValue_Exception_SetterOneArgument;
use Mail_ParamDataValue;

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

    /** @expectedException  DataValue_Exception_BadProperty */
    public function testBadGetterException()
    {
        $this->param->getException();
    }

    /** @expectedException  DataValue_Exception_BadProperty */
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

    protected function setUp()
    {
        parent::setUp();
        $this->param = new Mail_ParamDataValue();
    }

}
