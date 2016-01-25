<?php
/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */


namespace Tests\DataValue;


use DataValue_Exception_Property_ReadOnly;
use DataValue_Exception_Property_Required;

class PropertyTest extends \PHPUnit_Framework_TestCase
{
    /** @var  \DataValue_Property_PropertyInterface */
    protected $property;

    public function testValue()
    {
        $this->property->setValue("1");
        $this->assertEquals("1", $this->property->getValue());
    }

    public function testSetterReturnValue()
    {
        $this->assertInstanceOf("DataValue_Property_PropertyInterface", $this->property->setValue("1"));
    }

    public function testReadOnlyReturnValue()
    {
        $this->assertInstanceOf("DataValue_Property_PropertyInterface", $this->property->setReadOnly());
    }

    public function testRequiredReturnValue()
    {
        $this->assertInstanceOf("DataValue_Property_PropertyInterface", $this->property->setRequired());
    }

    public function testSetterReadOnly()
    {
        $this->property->setReadOnly();
        $this->assertFalse($this->property->isValueSet());

        $this->property->setValue("1");
        $this->assertTrue($this->property->isValueSet());
    }

    /** @expectedException  DataValue_Exception_Property_ReadOnly */
    public function testFailOnSettingReadOnly()
    {
        $this->property->setReadOnly();
        $this->property->setValue("1");
        $this->property->setValue("2");
    }

    public function testReadOnly()
    {
        $this->property
            ->setReadOnly()
            ->setValue("1");

        $this->assertEquals("1", $this->property->getValue());
        $this->assertEquals("1", $this->property->getValue());

    }

    public function testReadOnlyValue()
    {
        $this->property
            ->setReadOnly()
            ->setValue("1");
        try {
            $this->property->setValue("2");
        } catch (\Exception $e) {

        }

        $this->assertEquals("1", $this->property->getValue());
    }

    /** @expectedException DataValue_Exception_Property_Required */
    public function testRequiredFail()
    {
        $this->property->setRequired();
        $this->property->getValue();
    }

    public function testRequired()
    {

        $this->assertEquals("1", $this->property
            ->setRequired()
            ->setValue("1")
            ->getValue()
        );
    }

    protected function setUp()
    {
        parent::setUp();
        $this->property = new \DataValue_Property("test");
    }


}
