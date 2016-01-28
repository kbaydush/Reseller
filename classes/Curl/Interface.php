<?php

/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */
interface Curl_Interface
{

    /**
     * @param
     * @return boolean
     * @throws Exception
     */
    public function doHttpRequest();


    /**
     * @param string $curl_status
     * @return boolean
     * @throws Exception
     */
    public function httpResponseVerification($curl_status);

    /**
     * @param array $params
     * @return Curl
     * @throws Exception
     */
    public function setParams($params);

}
