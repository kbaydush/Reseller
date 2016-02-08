<?php
namespace reseller\Handler;
class Cron extends HandlerAbstract
{
    const PROCESS_FORM = 'cron';

    /**
     * @return $this
     */
    public function action()
    {

        if (!$this->Request->getDebugMode('cron')) {
            $this->logger->logInfo('Notice: Cron disabled.');
            die();

        }
        if ($this->Request->getDebugMode('pm') == true) {
            try {
                $this->Request->setDebugMode('force', true);
                $this->Request->setDebugMode('push', true);

                if (!$this->Request->loadStorage()) {
                    $this->logger->logInfo("Data file is empty.");
                } else {
                    $this->logger->logInfo('Request to the mirror has been started..........');

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

            } catch (\Exception $e) {
                $this->logger->logError($e->getMessage());
            }
        }

        return $this;
    }

    /**
     * @param array $request
     * @return $this
     */
    public function setRequestParams(array $request)
    {
        return $this;
    }

    /**
     * @param $formID
     * @return $this
     */
    public function setProcessFormID($formID)
    {
        return parent::setProcessFormID(self::PROCESS_FORM);
    }

}
