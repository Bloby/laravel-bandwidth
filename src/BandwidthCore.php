<?php

namespace Bandwidth;

use GuzzleHttp\Client;
use Carbon\Carbon;

class BandwidthCore {
        
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $api_url;

    /**
     * @var string
     */
    protected $account_id;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $timezone;

    /**
     * @var int
     */
    protected $timeout;

    /**
     * Instantiate a new instance
     */
    public function __construct()
    {
        $this->api_url          = config('bandwidth.url');
        $this->account_id        = config('bandwidth.account_id');
        $this->username         = config('bandwidth.username');
        $this->password         = config('bandwidth.password');
        $this->timezone         = config('bandwidth.timezone');

        $this->client = new Client([
            //'base_uri'  => sprintf('%s/%s', rtrim($this->api_url, '/'), ltrim($this->processor, '/')),
            'timeout'   => config('mor.timeout')
        ]);
    }

    /**
     * @param type 
     * @return string
     */
    public function submitGETRequest($data)
    {
        $response = $this->client->get('?', [
            'query' => $data,
            'http_errors' => true,
            'verify' => false
        ]);

        return (string)$response->getBody();
    }

    /**
     * Respond to a MOR request
     *
     * @param type
     * @return string
     */
    public function submitPOSTRequest($data)
    {
        $response = $this->client->get('?', [
            'query' => $data,
            'http_errors' => true,
            'verify' => false
        ]);

        return (string)$response->getBody();
    }

    public function getDate($format = 'YM')
    {
        return (string)Carbon::now($this->timezone)->format($format);
    }

    /**
     * @return string sha1 hash
     */
    public function getDatum()
    {
        return sha1($this->getDate('YM') . 'm0nk3ys');
    }

}