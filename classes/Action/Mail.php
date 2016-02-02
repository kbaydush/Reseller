<?php

class Action_Mail extends Action_Abstract
{
    /** @var  Mail_Attachment */
    protected $attachment;
    /** @var  Config_Mail */
    protected $mailFrom;
    /** @var  Mail_Params */
    protected $params;

    /**
     * Mail constructor.
     * @param Config_Mail $mailFrom
     */
    public function __construct(Config_Mail $mailFrom)
    {
        $this->mailFrom = $mailFrom;
    }

    /**
     * @param Config_Mail $mailTo
     * @return bool
     */
    public function send(Config_Mail $mailTo)
    {
        $header = $this->getHeader($this->getMessage());
        return @mail($mailTo->getEmail(), $this->generateSubject(), "", $header);
    }

    /**
     * @return string
     */
    private function getAttachmentData()
    {
        if (!is_null($this->attachment)) {
            $file = fopen($this->attachment->getFilePath(), "rb");
            $data = fread($file, filesize($this->attachment->getFilePath()));
            fclose($file);
            return chunk_split(base64_encode($data));
        } else {
            return "";
        }
    }

    /**
     * @return string
     */
    protected function generateSubject()
    {
        return 'Your ' . $this->params->getOrderProductNames() . ' Delivery Information';
    }

    /**
     * @return string
     */
    public function generateCustomerName()
    {
        return $this->params->getCustomerFirstName() . " " . $this->params->getCustomerLastName();
    }

    /**
     * @return string
     */
    public function generateLicence()
    {
        return 'SiteLicense-' . $this->params->getLicenseKey() . '.pdf';
    }


    /**
     * @param Mail_Attachment $attachment
     * @return Mail
     */
    public function setAttachment(Mail_Attachment $attachment)
    {
        $this->attachment = $attachment;
        return $this;
    }

    /**
     * @return string
     */
    private function getMessage()
    {
        return <<<EOM
<html><body>
Dear {$this->generateCustomerName()},<br/>
<br/>
Thank you for your order.<br/>
<br/>
<strong>DOWNLOAD INFORMATION</strong><br/>
You can download your project by clicking on the link below. Once you have downloaded the instructional
materials backup the files to a CD and keep them in a safe place. Please note the link will expire after 90 days.<br/>
<br/>
{$this->params->getUrl()}
<br/>
<br/>
If the above link does not work, please try opening a browser window and pasting the URL into the web address field.<br/>
<br/>
<br/>
Thanks,<br/>
The SomeCompanyName Team<br/>
@ SomeCompanyName <br/>
<br/>
***<br/>
<br/>
</body>
</html>
EOM;
    }

    /**
     * @param string $message
     * @return string
     */
    private function getHeader($message)
    {
        $attachmentData = $this->getAttachmentData();

        $from_name = $this->mailFrom->getName();
        $from_mail = $this->mailFrom->getEmail();

        $uid = md5(uniqid(time()));

        return <<<EOH
From: $from_name <$from_mail>
Reply-To: $from_name <$from_mail>
MIME-Version: 1.0
Content-Type: multipart/mixed; boundary="$uid"

This is a multi-part message in MIME format
--$uid
Content-type:text/html; charset=UTF-8
Content-Transfer-Encoding: 7bit

$message
--$uid
Content-Type: application/pdf; name="{$this->generateLicence()} "
Content-Transfer-Encoding: base64
Content-Disposition: attachment; filename="{$this->generateLicence()}"

$attachmentData;

--$uid
EOH;
    }

    public function setParams(Mail_Params $mailParams)
    {
        $this->params = $mailParams;
    }
}

