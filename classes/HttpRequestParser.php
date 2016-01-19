<?php

/**
 * {license_notice}
 *
 * @copyright   baidush.k
 * @license     {license_link}
 */
class HttpRequestParser
{


    /** @var Registry */
    private $config;

    /** @var array - Request params */
    private $params = array();

    /** @var array - Params from storage file */
    private $storage_params = array();

    /** @var array - Сombined file's and requested params all together */
    private $all_params = array();

    /** @var array - Debug mode params */
    private $debug_mode = array();

    /** @var string - Mirror's Url */
    public $url;

    /** @var string - Path name of pdf files which has been removed */
    public $rmdir = array();

    public $file_path;

    public $mail_headers;

    /**
     * @param Registry $config
     * @return $this
     */
    public function setConfig(Registry $config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @return Registry
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     *  To include params into html
     * @param string $html
     * @return string $html
     */
    public function varsToHtml($html)
    {
        foreach ($this->params as $params_key => $params_item) {
            if ($params_key == 'OrderProductNames') {
                $opn = array('{#OrderProductNames#}' => $this->config->get('order_product_names')[$this->params["OrderProductNames"]]);
                $html = strtr($html, $opn);

            } else {
                if (!empty($params_item) && $params_item != '') {
                    $html = strtr($html, array('{#' . $params_key . '#}' => $params_item));
                } else if ($params_item == '' || !isset($params_item)) {
                    $html = preg_replace('/{#' . $params_key . '#}<br>/i', '', $html);

                }
            }
        }

        $arr = array('/<b>{#.+#}<\/b><br>/i', '/<b>{#.+#}<\/b>/i', '/<b>{#.+#}.+<\/b>/i', '/{#.+#},/i', '/<br>{#.+#}.+<\/b><br>/i', '/<br>{#.+#}.+<br>/i', '/{#.+#}<\/br>/i');
        $html = preg_replace($arr, '', $html);
        return $html;
    }

    /**
     *  To setup debug params, using params from config by default
     * @param string $name , string $value
     * @return  void
     */

    public function setDebugMode($name, $value)
    {
        $this->debug_mode[$name] = $value;

    }

    /**
     *  To get debug params
     * @param string $name
     * @return boolean $mode
     */
    public function getDebugMode($name)
    {

        if ((isset($this->debug_mode[$name])
                && $this->debug_mode[$name] == 0)
            || isset($this->debug_mode[$name])
            && $this->debug_mode[$name] != ''
            && $this->debug_mode[$name] != null
        ) {
            $mode = $this->debug_mode[$name];
        } else {
            $mode = $this->config->get('DEBUG_MODE_BY_DEFAULT')[$name];
        }
        return $mode;
    }

    /**
     *  To set Url
     * @param string $url
     * @return HttpRequestParser
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     *  To get Url
     * @return string
     */
    public function getUrl()
    {

        return $this->config->get('MIRROR_SERVERS')[$this->getDebugMode('setmirror')];

    }

    /**
     *
     * @param string $action
     * @return boolean
     */
    public function initActionSet($action)
    {

        $setting_params = json_decode($this->getDebugMode($action));

        $obj_arr = $setting_params->{$action}->{$this->config->get('processFormId')};

        for ($i = 0; $i < count($obj_arr); $i++) {
            foreach ($obj_arr[$i] as $key => $val) {

                if ($this->getParams()[$key] == $val
                    || preg_match('/' . $val . '/', $this->getParams()[$key])
                ) {
                    return true;
                }
            }

        }

        return false;
    }

    /**
     *  To validate request params
     * @param: array $var_arr
     * @return boolean
     */
    private function validate($var_arr)
    {
        $name = trim($var_arr[0]);
        $value = trim($var_arr[1]);

        if (strlen($value) > 255) {
            $this->validError($name, $value);
        }

        $param_keys = array_keys($this->config->get('request_params')[$this->config->get('processFormId')]);

        switch ($name) {

            case 'OrderID':
            case 'CustomerCompany':
            case 'CustomerFirstName':
            case 'CustomerLastName':
            case 'AddressCountry':
            case 'AddressRegion':
            case 'AddressCity':
            case 'AddressStreet1':
            case 'AddressStreet2':

                $this->params[$name] = $value;

                break;

            case 'CustomerEmail':

                $valid = filter_var($value, FILTER_VALIDATE_EMAIL);
                if (!$valid) {
                    throw new \InvalidArgumentException("Email is not valid: " . $name . " Value: " . $value);
                }
                $this->params[$name] = $value;
                break;

            case 'OrderProductNames':

                if (array_key_exists($value, $this->config->get('order_product_names'))) {
                    $this->params[$name] = $value;
                } else if (!empty($value)) {
                    $this->params[$name] = $value;
                } else {
                    $this->validError($name, $value);
                }
                break;

            case 'formId':
            case 'formID':
            if ($value == $this->config->get('processFormId')) {
                    $this->params[$name] = $value;
                } else {
                    $this->validError($name, $value);
                }
                break;
            case 'productGroup':
                if (isset($value) && !empty($value)) {
                    $this->params[$name] = $value;
                } else {
                    $this->validError($name, $value);
                }
                break;

            default:

                if (in_array($name, $param_keys)) {
                    $value = htmlentities($value);
                    $value = addslashes($value);
                    $this->params[$name] = $value;
                } else if (array_key_exists($name, $this->config->get('DEBUG_MODE_BY_DEFAULT'))) {
                    $this->setDebugMode($name, $value);
                    $this->params[$name] = $value;
                } else {
                    $this->validError($name, $value);
                }
        }

        return true;
    }

    public function validError($name, $value)
    {
        throw new \InvalidArgumentException("Wrong parameter! Name: " . $name . " Value: " . $value);
    }

    /**
     *  To sync each of Mirror's param
     * @param
     * @return array $_params
     */
    public function mirrorKeys()
    {
        $request_params = $this->config->get('request_params')[$this->config->get('processFormId')];
        $_params = array();

        foreach ($this->params as $key => $value) {

            if (array_key_exists($key, $request_params)
                && !in_array($key, $this->config->get('params_disabled'))
                && !array_key_exists($key, $this->config->get('DEBUG_MODE_BY_DEFAULT'))
            )
                $_params[$request_params[$key]] = $value;

        }

        $_params['mirror_url'] = $this->getUrl();

        return $_params;
    }

    public function setParam($name, $value)
    {
        if ($this->validate(array($name, $value))) {
            return true;
        } else {
            header('HTTP/1.1 400 BAD_REQUEST');
            throw new \InvalidArgumentException("Setup non specific params");
        }
    }

    public function getParam($name)
    {
        return $this->params[$name];
    }


    public function setParams($post_params)
    {
        foreach ($post_params as $key => $value) {
            $this->setParam($key, $value);

        }
    }

    public function getParams()
    {
        return $this->params;
    }

    /**
     *  To load params from file
     * @Return: array
     */
    public function loadStorage()
    {
        if ($this->getDebugMode('push') == true) {

            $data_arr = file($this->config->get('root_dir') . '/storage', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            if (!empty($data_arr)) {
                foreach ($data_arr as $key => $value) {
                    parse_str($value, $data);
                    $this->storage_params[$key] = $data;
                }
            }
        }

        return $this->splitParams();
    }

    private function splitParams()
    {
        $this->all_params = $this->storage_params;
        if (!empty($this->params)) {
            array_push($this->all_params, $this->mirrorKeys());
        }
        foreach ($this->all_params as $data_key => $data_item) {
            if ($this->getDebugMode('force') == true) {
                $this->all_params[$data_key]['mirror_url'] = $this->getUrl();
            }
        }

        if (!empty($this->all_params)) {

            return $this->all_params;
        } else {
            return false;
        }
    }

    /**
     *  To remove of all pdf files that time was exceeded (The time has been set in config.php)
     * @param array $dir , string $structure
     * @return boolean
     */
    public function removeOldestPdf($dir, $structure = null)
    {
        $dir = $structure . $dir;
        $folder = explode('/', $dir);
        $folder = array_pop($folder);

        if (!file_exists($dir)) {
            return array('dirname' => $dir, 'result' => true);
        }

        if ((!is_dir($dir) || is_link($dir)) && $folder != 'files') {
            $this->rmdir[] = $dir;
            return array('dirname' => $dir, 'result' => unlink($dir));
        }

        if (!is_file($dir))
            foreach (scandir($dir) as $item) {

                if ($item == '.' || $item == '..' || $item == 'SiteLicense.html') continue;
                $fstat = stat($dir . "/" . $item);

                $convert = $fstat['ctime'];


                if (strtotime("+" . $this->config->get('pdf_lifetime') . " seconds", $convert) < strtotime("now")) {
                    $getRes = $this->removeOldestPdf($dir . "/" . $item);
                    if ($getRes['result'] == false) {
//                            chmod($dir . "/" . $item, 0777);
                        $getRes = $this->removeOldestPdf($dir . "/" . $item);
                        if ($getRes['result'] == false) return array('dirname' => $dir . "/" . $item, 'result' => false);
                    }
                    }

            }

        if ($folder != 'files') {
//            if (is_file($dir)) {
                $this->rmdir[] = $dir;

            return rmdir($dir);
//            }
        }

    }

    public function handle()
    {
        if ($this->loadStorage()) {
            $Response = $this->doHttpRequest();

            return $Response;
        }

    }

    private function doHttpRequest()
    {

        foreach ($this->all_params as $param_key => &$param_value_array) {

            if ($this->getDebugMode('force')) {
                $url = $this->getUrl();
            } else {
                $url = $this->all_params[$param_key]['mirror_url'];
            }

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

            curl_setopt($ch, CURLOPT_STDERR, fopen($this->config->get('root_dir') . '/logs/curl.log', 'a+'));

            $res = curl_exec($ch);
            $response[$param_key] = curl_getinfo($ch);

            curl_close($ch);
            $this->all_params[$param_key]['mirror_url'] = $url;

        }

        return $this->httpResponseVerification($response);

    }

    public function genPDF($html, $style = null)
    {

        $html_to_pdf = $this->varsToHtml($html);

        $_params = $this->getParams();

        //check unicode
        $only_latin = true;
        foreach ($_params as $key => $item) {
            if (strlen($item) != strlen(utf8_decode($item))) {
                $only_latin = false;
            }
        }

        $mpdf = new mPDF('utf-8', 'LETTER', '11', 'Arial', 10, 10, 8, 10, 20, 20, 'P', $only_latin); /* set format (margin, padding size, etc) */

        $mpdf->charset_in = 'utf-8';

//        $mpdf->SetAutoFont(AUTOFONT_CJK);

        $mpdf->simpleTables = true;
        $mpdf->useSubstitutions = false;

        $mpdf->SetTitle($this->config->get('pdf_title'));
        $mpdf->SetAuthor($this->config->get('pdf_author'));

        if (!empty($style))
            $mpdf->WriteHTML($style, 1);

        $mpdf->list_indent_first_level = 0;

        $mpdf->WriteHTML($html_to_pdf, 2);

        $structure = $this->config->get('root_dir');

        if (!file_exists($structure . '/files/' . $this->getParam('OrderID')))
            if (!mkdir($structure . '/files/' . $this->getParam('OrderID'), 0777, true)) {
                throw new \InvalidArgumentException('Failed to create folders...');
            }

        $this->file_path = $structure . '/files/' . $this->getParam('OrderID') . '/SiteLicense-' . $this->getParam('LicenseKey') . '.pdf';
        $mpdf->Output($this->file_path, 'F');
        return true;
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

            if ($this->getDebugMode('push') == true)
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
                } else if (in_array($st_value['redirect_url'], $this->config->get('response_wrong'))) {
                    fwrite($fp, trim(http_build_query($this->all_params[$st_key])) . PHP_EOL);
                    $curl_status[$st_key]['status'] = "Mirror does return error. Data does not submitted.";
                } else if (in_array($st_value['redirect_url'], $this->config->get('response_successfull'))) {
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
