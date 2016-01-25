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

    public function testFilePath()
    {
        $this->assertEquals("1", (new Mail_Attachment())->setFilePath("1")->getFilePath());
    }
}
