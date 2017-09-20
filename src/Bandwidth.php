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

    /**
     * @param string $state
     * @param integer|null $areaCode
     * @param integer|null $npaNxx
     * @param integer|null $npaNxxx
     * @param string|null $rateCenter
     * @param string|null $city
     * @param integer|null $zip
     * @param integer|null $lata
     * @param string|null $localVanity
     * @param string|null $tollFreeVanity
     * @param string|null $tollFreeWildCardPattern
     * @param integer|null $quantity
     * @param boolean|null $enableTNDetail
     * @param boolean|null $LCA
     * @param boolean|null $endsIn
     * @param string|null $orderBy one of (fullNumber, npaNxxx, npaNxx, areaCode)
     * @param null $protected NONE, ONLY, MIXED
     * @return object
     */
    public function availableNumbers($state, $areaCode = null, $npaNxx = null, $npaNxxx = null, $rateCenter = null, $city = null, $zip = null, $lata = null, $localVanity = null, $tollFreeVanity = null, $tollFreeWildCardPattern = null, $quantity = null, $enableTNDetail = null, $LCA = null, $endsIn = null, $orderBy = null, $protected = null)
    {
        return $this->submitGETRequest(
            sprintf('/accounts/%s/availableNumbers', $this->getAccountId()),
            compact(['state','areaCode','npaNxx','npaNxxx','rateCenter','city','zip','lata','localVanity','tollFreeVanity','tollFreeWildCardPattern','quantity','enableTNDetail','LCA','endsIn','orderBy','protected'])
        );
    }
}