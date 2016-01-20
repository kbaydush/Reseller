<?php

class Handler_Http extends Handler_Abstract
{

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

        if ($this->Request->getDebugMode('request') == true) {
            try {
                if ($this->Request->loadStorage()) {
                    $this->logger->logInfo("Message: Request to the mirror has been started..........");

                    $response = $this->Request->handle();

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

        if ($this->Request->getDebugMode('pdf')) {

            $replacement = '@separator@';
            $html = file_get_contents($this->Request->getConfig()->get('root_dir') . '/files/SiteLicense.html');
            $search = preg_replace("#(.*)<style>(.*?)</style>(.*)#is", "$1{$replacement}$2{$replacement}$3", $html);
            $array_html = explode('@separator@', $search);
            $head = $array_html[0];
            $style = $array_html[1];
            $body = $array_html[2];
            $html = $head . $body;
            $getRes = $this->Request->removeOldestPdf('/files', $this->Request->getConfig()->get('root_dir'));
            if (!empty($getRes) && $getRes['result'] == false) {
                $this->logger->logError('PDF file - ' . $getRes['dirname'] . ' does not removed correctly. Lifetime is ' . $this->Request->getConfig()->get('pdf_lifetime') . ' ms');
            }
            $attach_pdf = $this->Request->genPDF($html, $style);

            foreach ($this->Request->rmdir as $key => $item) {
                $this->logger->logInfo('File has been removed -  ' . $item);

            }
            $this->logger->logInfo('PDF saved in directory ' . 'files/' . $this->Request->getParam('OrderID') . '/SiteLicense-' . $this->Request->getParam('LicenseKey') . '.pdf');
        } else {
            $attach_pdf = false;
        }

// SEND MAIL

        if ($this->Request->getDebugMode('mail')) {
            try {

                if ($this->Request->getDebugMode('mail_test') == true) {
                    $mailto = $this->Request->getConfig()->get('test_mail');
                } else {
                    $mailto = $this->Request->getParam('CustomerEmail');
                }

                if ($this->Request->getDebugMode('mail') == true) {
                    $sent_result = $this->Request->send_mail($mailto, $attach_pdf, $this->Request->file_path);
                    if ($sent_result) {
                        $this->logger->logInfo('Mail is correctly sent to ' . $mailto);
                    }
                }

            } catch (Exception $e) {
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
            print_r($this->Request->getConfig()->getAll(), 0);
            echo "<br/>";
            echo "<br/>";
            echo "REQUEST PARAMS: ";
            echo "<br/>";
            echo "<br/>";
            print_r($this->Request->getParams(), 0);

        }

    }
}
