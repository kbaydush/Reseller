<?php
namespace reseller\Action;

class Curl extends ActionAbstract
{

    public $all_params;

    public function doHttpRequest()
    {
        $this->all_params = $this->getStorage();
        foreach ($this->all_params as $param_key => &$param_value_array) {

            $url = $this->all_params[$param_key]['mirror_url'];

            // mirror_url parameter must not sending to mirror
            unset($this->all_params[$param_key]['mirror_url']);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_PORT, 80);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

            curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Content-Type: application/json',
                'Charset: UTF-8'
            ));
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
            curl_setopt($ch, CURLOPT_REFERER, 'http://testsite.localhost/purchase.html');
            curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param_value_array));

            curl_setopt($ch, CURLOPT_STDERR, fopen($this->Request->getConfig()->getRootDirectory() . '/logs/curl.log', 'a+'));

            $res = curl_exec($ch);
            $response[$param_key] = curl_getinfo($ch);

            curl_close($ch);
            $this->all_params[$param_key]['mirror_url'] = $url;

        }

        return $this->httpResponseVerification($response);

    }


    /**
     *  To check response
     * @param array $curl_status
     * @return array $curl_status
     */
    public function httpResponseVerification($curl_status)
    {

        $fp = fopen('./data/storage', 'a+') or exit("Can't open storage file");

        if (flock($fp, LOCK_EX)) {

            if ($this->Request->getDebugMode('push') == true)
                ftruncate($fp, 0);

            foreach ($curl_status as $st_key => $st_value) {

                $curl_status[$st_key]['mirror_url'] = $this->all_params[$st_key]['mirror_url'];

                if ($st_value['http_code'] == 0) {
                    fwrite($fp, trim(http_build_query($this->all_params[$st_key])) . PHP_EOL);
                    $curl_status[$st_key]['status'] = "Server unavailable.";

                } else if ($st_value['http_code'] == 503) {
                    fwrite($fp, trim(http_build_query($this->all_params[$st_key])) . PHP_EOL);
                    $curl_status[$st_key]['status'] = "Service unavailable.";
                } else if ($st_value['http_code'] == 404) {
                    fwrite($fp, trim(http_build_query($this->all_params[$st_key])) . PHP_EOL);
                    $curl_status[$st_key]['status'] = "Page not found.";
                } else if (in_array($st_value['redirect_url'], $this->Request->registry->get('response_wrong'))) {
                    fwrite($fp, trim(http_build_query($this->Request->all_params[$st_key])) . PHP_EOL);
                    $curl_status[$st_key]['status'] = "Mirror does return error. Data does not submitted.";
                } else if (in_array($st_value['redirect_url'], $this->Request->registry->get('response_successfull'))) {
                    echo "Success: Form data has been submited successfully! <br>";
                } else {
                    fwrite($fp, trim(http_build_query($this->all_params[$st_key])) . PHP_EOL);
                    $curl_status[$st_key]['status'] = "Wrong response! Mirror server does not returned the 302 redirect.";
                }

                $curl_status[$st_key]['formId'] = $this->all_params[$st_key]['formID'];

            }
        }
        fclose($fp);

        return $curl_status;
    }

}
