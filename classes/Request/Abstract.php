<?php

/**
 * {license_notice}
 *
 * @copyright   baidush.k
 * @license     {license_link}
 */
class Request_Abstract
{
    protected $processFormId = Handler_Cron::PROCESS_FORM;


    /** @var Registry */
    protected $registry;

    /** @var array - Request params */
    protected $params = array();

    /** @var array - Params from storage file */
    protected $storage_params = array();

    /** @var array - Сombined file's and requested params all together */
    protected $all_params = array();

    /** @var array - Debug mode params */
    protected $debug_mode = array();

    /** @var string - Mirror's Url */
    public $url;

    /** @var string - Path name of pdf files which has been removed */
    public $rmdir = array();

    public $file_path;

    public $mail_headers;
    /** @var  Config */
    protected $config;

    /**
     * @param Registry $registry
     * @return $this
     */
    protected function setRegistry(Registry $registry)
    {
        $this->registry = $registry;
        return $this;
    }

    /**
     * @return Registry
     */
    public function getRegistry()
    {
        return $this->registry;
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
            $mode = $this->registry->get('DEBUG_MODE_BY_DEFAULT')[$name];
        }
        return $mode;
    }

    /**
     *  To set Url
     * @param string $url
     * @return Request_Abstract
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

        return $this->registry->get('MIRROR_SERVERS')[$this->getDebugMode('setmirror')];

    }

    /**
     * @deprecated
     * @param string $action
     * @return boolean
     */
    public function initActionSet($action)
    {

        $setting_params = json_decode($this->getDebugMode($action));

        $obj_arr = $setting_params->{$action}->{$this->processFormId};

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

        $param_keys = array_keys($this->registry->get('request_settings')[$this->command]['fnames']);

        switch ($name) {

            case 'formId':
            case 'OrderID':
            case 'CustomerCompany':
            case 'CustomerFirstName':

                $this->params[$name] = $value;
                break;
            case 'CustomerEmail':

                $valid = filter_var($value, FILTER_VALIDATE_EMAIL);
                if (!$valid) {
                    throw new \InvalidArgumentException("Email is not valid: " . $name . " Value: " . $value);
                }
                $this->params[$name] = $value;
                break;
            default:

                if (in_array($name, $param_keys)) {
                    $value = htmlentities($value);
                    $value = addslashes($value);
                    $this->params[$name] = $value;
                } else if (array_key_exists($name, $this->registry->get('DEBUG_MODE_BY_DEFAULT'))) {
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
        $request_params = $this->registry->get('request_settings')[$this->command]['fnames'];
        $_params = array();

        foreach ($this->params as $key => $value) {

            if (array_key_exists($key, $request_params)
                && !in_array($key, $this->registry->get('params_disabled'))
                && !array_key_exists($key, $this->registry->get('DEBUG_MODE_BY_DEFAULT'))
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

            $data_arr = file($this->getConfig()->getRootDirectory() . '/storage', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

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

    public function handle()
    {
        if ($this->loadStorage()) {
            $Response = $this->doHttpRequest();

            return $Response;
        }

    }


    /**
     * @param mixed $processFormId
     */
    public function setProcessFormId($processFormId)
    {
        $this->processFormId = $processFormId;
    }

    /**
     * @param Config $config
     * @return $this
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;
        $this->registry = $config->getRegistry();
        return $this;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }
}
