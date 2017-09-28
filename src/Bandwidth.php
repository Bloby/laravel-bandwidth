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
    public function availableNumbers($state = null, $areaCode = null, $npaNxx = null, $npaNxxx = null, $rateCenter = null, $city = null, $zip = null, $lata = null, $localVanity = null, $tollFreeVanity = null, $tollFreeWildCardPattern = null, $quantity = null, $enableTNDetail = null, $LCA = null, $endsIn = null, $orderBy = null, $protected = null)
    {
        return $this->submitGETRequest(
            sprintf('/accounts/%s/availableNumbers', $this->getAccountId()),
            compact(['state','areaCode','npaNxx','npaNxxx','rateCenter','city','zip','lata','localVanity','tollFreeVanity','tollFreeWildCardPattern','quantity','enableTNDetail','LCA','endsIn','orderBy','protected'])
        );
    }

    /**
     * @param string|bool $fullCheck one of (true, false, onnetportability, offnetportability), default: false
     * @param array $tns
     * @return object
     */
    public function lnpchecker($fullCheck, $tns)
    {
        $xml = '<NumberPortabilityRequest><TnList>%s</TnList></NumberPortabilityRequest>';
        $list = '';
        foreach ($tns as $tn) {
            $list .= sprintf('<Tn>%s</Tn>', $tn);
        }

        return $this->submitPOSTRawRequest(
            sprintf('/accounts/%s/lnpchecker', $this->getAccountId()),
            compact(['fullCheck']),
            sprintf($xml, $list)
        );
    }

    /**
     * @param array|null $TelephoneNumbers [TelephoneNumber][]
     * @param string|null $CallerName
     * @param array|null $Address
     * <Address>
        <HouseNumber>915</HouseNumber>
        <HouseSuffix/>
        <PreDirectional/>
        <StreetName>Elm</StreetName>
        <StreetSuffix>Ave</StreetSuffix>
        <PostDirectional/>
        <AddressLine2/>
        <City>Carpinteria</City>
        <StateCode>CA</StateCode>
        <Zip>93013</Zip>
        <PlusFour/>
        <County/>
        <Country>United States</Country>
    </Address>
     *
     * @param boolean|null $DeleteTNSpecificE911Address
     * @param null $AlternateEndUserIdentifiers
     * @param null $AdditionalAddresses
     * @param null $AddressesToDelete
     * @param null $EndpointsToEdit
     * @param null $AddressesToEdit
     * @return object
     */
    public function e911sCreate($TelephoneNumbers = null, $CallerName = null, $Address = null, $DeleteTNSpecificE911Address = null, $AlternateEndUserIdentifiers = null, $AdditionalAddresses = null, $AddressesToDelete = null, $EndpointsToEdit = null, $AddressesToEdit = null)
    {
        return $this->submitPOSTRequest(
            sprintf('/accounts/%s/e911s', $this->getAccountId()),
            compact(['TelephoneNumbers','CallerName','Address','DeleteTNSpecificE911Address','AlternateEndUserIdentifiers','AdditionalAddresses','AddressesToDelete','EndpointsToEdit','AddressesToEdit'])
        );
    }

    /**
     * @param string $aeui
     * @param string|null $callBack
     * @param string|null $createdDateFrom
     * @param string|null $createdDateTo
     * @param string|null $customerOrderId
     * @param string|null $lastModifiedAfter
     * @param string|null $lastModifiedBy
     * @param string|null $modifiedDateFrom
     * @param string|null $modifiedDateTo
     * @param boolean|null $orderDetails
     * @param string|null $orderIdFragment
     * @param string|null $status one of (RECEIVED, PROCESSING, COMPLETE, PARTIAL, FAILED, ADJUSTED_COMPLETE, ADJUSTED_PARTIAL), repeatable
     * @param string|null $tn
     * @return object
     */
    public function e911sList($aeui, $callBack = null, $createdDateFrom = null, $createdDateTo = null, $customerOrderId = null, $lastModifiedAfter = null, $lastModifiedBy = null, $modifiedDateFrom = null, $modifiedDateTo = null, $orderDetails = null, $orderIdFragment = null, $status = null, $tn = null)
    {
        return $this->submitPOSTRequest(
            sprintf('/accounts/%s/e911s', $this->getAccountId()),
            compact(['aeui','callBack','createdDateFrom','createdDateTo','customerOrderId','lastModifiedAfter','lastModifiedBy','modifiedDateFrom','modifiedDateTo','orderDetails','orderIdFragment','status','tn'])
        );
    }
}