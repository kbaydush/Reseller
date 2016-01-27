<?php
/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */


namespace DataValue\Mail;


use Mail_Attachment;

class AttachmentTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Mail_Attachment */
    protected $obj;

    public function testFilePath()
    {
        $this->assertEquals("1", $this->obj->setFilePath("1")->getFilePath());
    }

    /** @expectedException \DataValue_Exception_Property_ReadOnly */
    public function testReadOnly()
    {
        $this->obj->setFilePath("1")
            ->setFilePath("2");
    }

    public function testReadOnlyValue()
    {
        $this->obj->setFilePath("1");
        try {
            $this->obj->setFilePath("2");
        } catch (\Exception $e) {

        }

        $this->assertEquals("1", $this->obj->getFilePath());
    }

    public function testRequired()
    {
        $isError = false;
        try {
            $this->obj->getFilePath();
        } catch (\Exception $e) {
            $isError = true;
        }
        $this->assertTrue($isError);
        $this->obj->setFilePath("1");
        $this->assertEquals("1", $this->obj->getFilePath());
    }

    protected function setUp()
    {
        parent::setUp();

        $this->obj = new Mail_Attachment();
    }


}
