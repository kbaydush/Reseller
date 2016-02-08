<?php
namespace reseller\Handler;
use reseller\Action\Curl;
use reseller\Action\Mail;
use reseller\Action\Pdf;
use reseller\Mail\Attachment;
use reseller\Mail\Params;
use reseller\Config\ConfigMail;
class Http extends HandlerAbstract
{

    /**
     * @param string $command
     * @param Config $config
     * @return Handler_Abstract
     */
    public function getAction($action_mode)
    {
        switch ($action_mode) {

            case "curl_http_request":
                $Action = new Curl($this->Request->getConfig());
                break;

            case "pdf_creator":
                $Action = new Pdf($this->Request->getConfig());
                break;

            case "mail":
                $Action = new Mail($this->Request->getConfig());
                break;

        }

        return $Action->setRequestData($this->Request);
    }


    public function action()
    {

        if ($this->Request->getParams()['drop'] == true) {
            $res = unlink($this->Request->getParams()->root_dir . '/data/storage');
            if ($res == true) {
                echo "File droped";
                $this->logger->logInfo("Data file (./data/storage) has been dropped.");
            }
            die();
        }

// Request to the mirror

        if ($this->Request->getDebugMode('curl_http_request') == true) {


            try {
                if ($this->Request->loadStorage()) {
                    $this->logger->logInfo("Message: Request to the mirror has been started..........");

                    $response = $this->getAction('curl_http_request')->doHttpRequest();

                    foreach ($response as $key => $val) {
                        $this->logger->logInfo('Server URL: ' . $val['mirror_url']);
                        $this->logger->logInfo('FormId: ' . $val['formId']);
                        $this->logger->logInfo('Response: ' . http_build_query($val));
                        if (!empty($response[$key]['status'])) {
                            header('HTTP/1.1 400 BAD_REQUEST');
                            $this->logger->logError($response[$key]['status']);
                        }
                    }
                }

            } catch (Exception $e) {
                header('HTTP/1.1 400 BAD_REQUEST');
                $this->logger->logError($e->getMessage());
                die();
            }

        }

// Generate PDF

        if ($this->Request->getDebugMode('pdf_creator')) {

            $replacement = '@separator@';
            $html = file_get_contents($this->Request->getConfig()->getRootDirectory() . '/files/SiteLicense.html');
            $search = preg_replace("#(.*)<style>(.*?)</style>(.*)#is", "$1{$replacement}$2{$replacement}$3", $html);
            $array_html = explode('@separator@', $search);
            $head = $array_html[0];
            $style = $array_html[1];
            $body = $array_html[2];
            $html = $head . $body;
            $getRes = $this->getAction('pdf_creator')->removeOldestPdf('/files', $this->Request->getConfig()->getRootDirectory());
            if (!empty($getRes) && $getRes['result'] == false) {
                $this->logger->logError('PDF file - ' . $getRes['dirname'] . ' does not removed correctly. Lifetime is ' . $this->Request->getConfig()->getPdf()->getLifetime() . ' ms');
            }
            $attach_pdf = $this->getAction('pdf_creator')->genPDF($html, $style);

            foreach ($this->Request->rmdir as $key => $item) {
                $this->logger->logInfo('File has been removed -  ' . $item);

            }
            $this->logger->logInfo('PDF saved in directory ' . 'files/' . $this->Request->getParam('OrderID') . '/SiteLicense-' . $this->Request->getParam('LicenseKey') . '.pdf');
        } else {
            $attach_pdf = false;
        }

// SEND MAIL

        if ($this->Request->getDebugMode('send_mail')) {
            try {

                if ($this->Request->getDebugMode('mail_test') == true) {
                    $mailTo = $this->Request->getConfig()->getMailTest();
                } else {
                    $mailTo = new ConfigMail($this->Request->getParam('CustomerEmail'));
                }

                $mail = new Mail($this->Request->getConfig()->getMailFrom());
                if ($attach_pdf === true) {
                    $attachment = new Attachment();
                    $attachment->setFilePath($this->Request->file_path);
                    $mail->setAttachment($attachment);
                }

                $mailParams = new Params();
                $mailParams->setCustomerFirstName($this->Request->getParam('CustomerFirstName'))
                    ->setCustomerLastName($this->Request->getParam('CustomerLastName'))
                    ->setLicenseKey($this->Request->getParam('LicenseKey'))
                    ->setOrderProductNames($this->Request->getParam('OrderProductNames'))
                    ->setUrl($this->Request->getParam('url'));

                $mail->setParams($mailParams);

                if (!$mail->send($mailTo)) {
                    $this->logger->logInfo('Mail is correctly sent to ' . $mailTo->toString());
                }

            } catch (\Exception $e) {
                $this->logger->logError($e->getMessage());
                $this->logger->logError("Mail didn't sent");
                die();
            }
        }


        if ($this->Request->getDebugMode('info') == true) {

            echo "<br/>";

            echo "CONFIG: ";
            echo "<br/>";
            echo "<br/>";
            print_r($this->Request->getRegistry()->getAll(), 0);
            echo "<br/>";
            echo "<br/>";
            echo "REQUEST PARAMS: ";
            echo "<br/>";
            echo "<br/>";
            print_r($this->Request->getParams(), 0);

        }

    }
}
