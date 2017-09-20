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
     * @param string $state
     * @param bool $available
     * @param bool $supported
     * @return object
     */
    public function getCities($state, $available = true, $supported = true)
    {
        return $this->submitGETRequest('/cities', compact(['state','available','supported']));
    }

    /**
     * @param string $state
     * @param bool $available
     * @param bool $supported
     * @return object
     */
    public function getRateCenters($state, $available = true, $supported = true)
    {
        return $this->submitGETRequest('/rateCenters', compact(['state','available','supported']));
    }
}