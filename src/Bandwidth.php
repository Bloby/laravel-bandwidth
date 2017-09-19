<?php

namespace Bandwidth;

class Bandwidth extends BandwidthCore {
    
    /**
     * Instantiate a new instance
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $did
     * @param $client_id
     * @return string
     */
    public function checkDID($did, $client_id)
    {
        $data = [
            'cmd'       => 'check_did',
            'auth'      => $this->getDatum(),
            'did'       => $did,
            'client_id' => $client_id,
        ];

        return $this->submitRequest($data);
    }

    /**
     * @param string $state
     * @param bool $available
     * @param bool $supported
     * @return object
     */
    public function getCities($state, $available = true, $supported = true)
    {
        return $this->submitGETRequest('/cities', compact(['state','available','supported']));
    }
}