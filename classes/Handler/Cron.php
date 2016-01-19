<?php

class  Handler_Cron extends Handler_Abstract
{
    public function action()
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

        return $this;
    }

    public function setRequestParams(array $request)
    {
        return $this;
    }

}
