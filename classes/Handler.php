<?php

/**
 * {license_notice}
 *
 * @copyright   baidush.k
 * @license     {license_link}
 */
class Handler
{
    /** @var Logger_Interface */
    private $error_log;
    /** @var Logger_Interface */
    private $query_log;
    /** @var HttpRequestParser */
    private $Request;

    public function __construct($CFG, $formId)
    {

// Set real formId

        $CFG->set('processFormId', $formId);

// set path and name of the log file (optionally)
        $this->error_log = new Logging($CFG->get('logs_dir') . 'error.log');
        $this->query_log = new Logging($CFG->get('logs_dir') . 'query.log');

        try {
            $this->Request = new HttpRequestParser();

            if (empty($CFG) || !isset($CFG)) {
                throw new \InvalidArgumentException("Bootstrap failed!");

            } else {
                $this->Request->setConfig($CFG);
            }

        } catch (Exception $e) {
            header('HTTP/1.1 400 BAD_REQUEST');
            $this->error_log->logError($e->getMessage());
            die();
        }
    }

    public function setRequestParams($GET, $POST)
    {
        try {

            if ($this->Request->getConfig()->get('processFormId') != 'cron')
                if (count($POST) > 0) {

                    $this->Request->setParams($POST);
                } else if (count($GET) > 0) {
                    $this->Request->setParams($GET);


                } else {
                    throw new \InvalidArgumentException("Required params are absent!");
                }

        } catch (Exception $e) {
            header('HTTP/1.1 400 BAD_REQUEST');
            $this->error_log->logError($e->getMessage());
            die();
        }

        return true;
    }

    function __destruct()
    {
        unset($this->query_log);
        unset($this->error_log);

        echo "Done.";
    }

    public function action()
    {

        if ($this->Request->getParams()['drop'] == true) {
            $res = unlink($this->Request->getParams()->root_dir . '/data/storage');
            if ($res == true) {
                echo "File droped";
                $this->query_log->logInfo("Data file (./data/storage) has been dropped.");
            }
            die();
        }

// Request to the mirror

        if ($this->Request->getDebugMode('request') == true) {
            try {
                if ($this->Request->loadStorage()) {
                    $this->query_log->logInfo("Message: Request to the mirror has been started..........");

                    $response = $this->Request->handle();

                    foreach ($response as $key => $val) {
                        $this->query_log->logInfo('Server URL: ' . $val['mirror_url']);
                        $this->query_log->logInfo('FormId: ' . $val['formId']);
                        $this->query_log->logInfo('Response: ' . http_build_query($val));
                        if (!empty($response[$key]['status'])) {
                            header('HTTP/1.1 400 BAD_REQUEST');
                            $this->error_log->logError($response[$key]['status']);
                        }
                    }
                }

            } catch (Exception $e) {
                header('HTTP/1.1 400 BAD_REQUEST');
                $this->error_log->logError($e->getMessage());
                die();
            }

        }

// Generate PDF

        if ($this->Request->getDebugMode('pdf')) {
            require_once $this->Request->getConfig()->get('root_dir') . "/lib/MPDF57/mpdf.php";
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
                $this->error_log->logError('PDF file - ' . $getRes['dirname'] . ' does not removed correctly. Lifetime is ' . $this->Request->getConfig()->get('pdf_lifetime') . ' ms');
            }
            $attach_pdf = $this->Request->genPDF($html, $style);

            foreach ($this->Request->rmdir as $key => $item) {
                $this->query_log->logInfo('File has been removed -  ' . $item);

            }
            $this->query_log->logInfo('PDF saved in directory ' . 'files/' . $this->Request->getParam('OrderID') . '/SiteLicense-' . $this->Request->getParam('LicenseKey') . '.pdf');
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
                        $this->query_log->logInfo('Mail is correctly sent to ' . $mailto);
                    }
                }

            } catch (Exception $e) {
                $this->error_log->logError($e->getMessage());
                $this->error_log->logError("Mail didn't sent");
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

    public function actionCron()
    {

        if (!$this->Request->getDebugMode('cron')) {
            $this->query_log->logInfo('Notice: Cron disabled.');
            die();

        }
        if ($this->Request->getDebugMode('pm') == true) {
            try {
                $this->Request->setDebugMode('force', true);
                $this->Request->setDebugMode('push', true);

                if (!$this->Request->loadStorage()) {
                    $this->error_log->logInfo("Data file is empty.");
                } else {
                    $this->query_log->logInfo('Request to the mirror has been started..........');

                    $response = $this->Request->handle();

                    foreach ($response as $key => $val) {
                        $this->query_log->logInfo('Server URL: ' . $val['mirror_url']);
                        $this->query_log->logInfo('FormId: ' . $val['formId']);
                        $this->query_log->logInfo('Response: ' . http_build_query($val));
                        if (!empty($response[$key]['status'])) {
                            header('HTTP/1.1 400 BAD_REQUEST');
                            $this->error_log->logError($response[$key]['status']);
                        }
                    }
                }

            } catch (Exception $e) {
                $this->error_log->logError($e->getMessage());
            }
        }
    }

}
