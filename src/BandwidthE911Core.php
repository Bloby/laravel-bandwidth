<?php

namespace Bandwidth;

use Carbon\Carbon;

class BandwidthE911Core {
        
    /**
     * @var \SoapClient
     */
    protected $client;

    /**
     * @var string
     */
    protected $api_url;

    /**
     * @var string
     */
    protected $login;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var \SoapFault
     */
    private $_errorString;
    private $_errorCode;
    private $_callback;

    /**
     * Instantiate a new instance
     */
    public function __construct()
    {
        $this->api_url      = config('bandwidth.e911.url');
        $this->login        = config('bandwidth.e911.login');
        $this->password     = config('bandwidth.e911.password');

        $this->client = new \SoapClient($this->api_url, ['login' => $this->login, 'password' => $this->password]);
    }

    public function setCallback($callback)
    {
        if (!is_string($callback) && !is_array($callback)) {
            return false;
        }

        $this->_callback = $callback;
        return true;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getErrorCode()
    {
        return $this->_errorCode;
    }

    public function getErrorString()
    {
        return $this->_errorString;
    }

    public function getError()
    {
        if ($this->_errorString) {
            return sprintf('Error: (code: %s, message: %s)', $this->_errorCode, $this->_errorString);
        }
        return null;
    }

    public function getAvailableMethods()
    {
        if (!isset($this->client)) {
            return null;
        }

        $soapFunctions = $this->client->__getFunctions();
        for ($i = 0, $count = count($soapFunctions); $i < $count; ++$i) {
            preg_match("/[\s\S]*?(didww_[\s\S]*?)\([\s\S]*?/", $soapFunctions[$i], $match);
            $soapFunctions[$i] = $match[1];
        }

        return $soapFunctions;
    }

    /**
     * @param $method
     * @param array $params
     * @return object
     */
    public function _handleQuery($method, $params = [])
    {
        if (!isset($this->client)) {
            return null; // client undefined if missed internet connection
        }

        $params = $this->filterData($params);
        $timeStart = microtime(true);

        try
        {
            $this->_errorCode = null;
            $this->_errorString = null;
            //time measure
            $result = $this->client->__soapCall($method, $params);

            if (is_null($result)) {
                throw new \Exception('Undefined API result');
            }
        }
        catch(\SoapFault $e)
        {
            $this->_errorCode = $e->getCode();
            $this->_errorString = $e->getMessage();
            $result = null;
        }
        catch(\Exception $e)
        {
            $this->_errorCode = $e->getCode();
            $this->_errorString = $e->getMessage();
            $result = null;
        }

        $timeFinish = microtime(true);

        if ($this->_callback) {
            call_user_func_array($this->_callback, [
                'result' => $result,
                'method' => $method,
                'params' => $params,
                'error' => $this->_errorString,
                'code' => $this->_errorCode,
                'seconds' => $timeFinish - $timeStart
            ]);
        }

        return $result;
    }

    public function filterData($params)
    {
        return array_filter($params, function($value){return !is_null($value);});
    }

}