<?php
/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */


namespace Tests\DataValue;


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


    protected function setUp()
    {
        parent::setUp();
        $this->property = new \DataValue_Property();
    }


}
