<?php

class Request_Mail extends Request_Abstract
{

    /**
     *  To sending Mail
     * @param string $mailto , boolean $attach_pdf, string $file_path
     * @return boolean
     */

    public function send_mail($mailto, $attach_pdf, $file_path = null)
    {

        $params = $this->getParams();
        $str_params = '';
        foreach ($params as $key => $val) {
            $str_params .= $key . ' : ' . $val . ' ; ';
        }

        if ($attach_pdf == true) {
            $file = fopen($file_path, "rb");

            $data = fread($file, filesize($file_path));

            fclose($file);

            $data = chunk_split(base64_encode($data));
        }

        $from_name = 'SomeCompanyName Orders';
        $from_mail = $this->config->get('mail_from');
        $uid = md5(uniqid(time()));
        $subject = 'Your ' . $this->getParam('OrderProductNames') . ' Delivery Information';
        $filename = 'SiteLicense-' . $this->getParam('LicenseKey') . '.pdf';
        $message = <<<EOM
<html><body>
Dear {$this->params['CustomerFirstName']} {$this->params['CustomerLastName']},<br/>
<br/>
Thank you for your order.<br/>
<br/>
<strong>DOWNLOAD INFORMATION</strong><br/>
You can download your project by clicking on the link below. Once you have downloaded the instructional
materials backup the files to a CD and keep them in a safe place. Please note the link will expire after 90 days.<br/>
<br/>
{$this->params['url']}
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

        $header = <<<EOH
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
Content-Type: application/pdf; name="$filename"
Content-Transfer-Encoding: base64
Content-Disposition: attachment; filename="$filename"

$data;
--$uid
EOH;

        $this->mail_headers = $header;
        return @mail($mailto, $subject, "", $header);
    }
}

?>