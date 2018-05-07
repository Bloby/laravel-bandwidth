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
     * @param string $LoaAuthorizingPerson
     * @param string $BillingTelephoneNumber
     * @param array $ListOfPhoneNumbers
     * @param string $SiteId
     * @param string $SubscriberType
     * @param string $HouseNumber
     * @param string $StreetName
     * @param string $City
     * @param integer $Zip
     * @param string $StateCode
     * @param string|null $County
     * @param string|null $PeerId
     * @param string|null $RequestedFocDate
     * @param string|null $AlternateSpid
     * @param string|null $FirstName
     * @param string|null $LastName
     * @return object
     */
    public function portinsCreate(
        $LoaAuthorizingPerson, $BillingTelephoneNumber, $ListOfPhoneNumbers, $SiteId, $SubscriberType, $HouseNumber,
        $StreetName, $City, $Zip, $StateCode, $County = null, $PeerId = null, $RequestedFocDate = null, $AlternateSpid = null,
        $FirstName = null, $LastName = null
    )
    {
        $xml = '<LnpOrder>%s</LnpOrder>';
/*`<LnpOrder>
    <RequestedFocDate>2016-03-25T21:15:00.000Z</RequestedFocDate>
    <!-- OPTIONAL -->
    <AlternateSpid>X455</AlternateSpid>
    <!-- OPTIONAL -->
    <BillingTelephoneNumber>9195551234</BillingTelephoneNumber>
    <SiteId>    SITE ID     </SiteId>
    <PeerId>  SIPPEER ID    </PeerId>
    <Subscriber>
        <SubscriberType>BUSINESS</SubscriberType>
        <FirstName>First</FirstName>
        <LastName>Last</LastName>
        <ServiceAddress>
            <HouseNumber>11235</HouseNumber>
            <StreetName>Back</StreetName>
            <City>Denver</City>
            <StateCode>CO</StateCode>
            <Zip>27541</Zip>
            <County>Canyon</County>
        </ServiceAddress>
    </Subscriber>
    <LoaAuthorizingPerson>The Authguy</LoaAuthorizingPerson>
    <WirelessInfo>
        <AccountNumber>771297665AABC</AccountNumber>
        <PinNumber>1234</PinNumber>
    </WirelessInfo>
    <TnAttributes>
        <TnAttribute>Protected</TnAttribute>
    </TnAttributes>
    <ListOfPhoneNumbers>
        <PhoneNumber>9194809871</PhoneNumber>
    </ListOfPhoneNumbers>
    <Triggered>true</Triggered>
    <BillingType>PORTIN</BillingType>
</LnpOrder>`;*/
        $list = '';

        $list .= sprintf('<BillingTelephoneNumber>%s</BillingTelephoneNumber>', $BillingTelephoneNumber);
        $list .= sprintf('<SiteId>%s</SiteId>', $SiteId);

        if ($PeerId !== null) {
            $list .= sprintf('<PeerId>%s</PeerId>', $PeerId);
        }

        if ($RequestedFocDate !== null) {
            $list .= sprintf('<RequestedFocDate>%s</RequestedFocDate>', $RequestedFocDate);
        }

        if ($AlternateSpid !== null) {
            $list .= sprintf('<AlternateSpid>%s</AlternateSpid>', $AlternateSpid);
        }

        $Subscriber = '';
        $Subscriber .= sprintf('<SubscriberType>%s</SubscriberType>', $SubscriberType);

        if ($FirstName !== null) {
            $Subscriber .= sprintf('<FirstName>%s</FirstName>', $FirstName);
        }

        if ($LastName !== null) {
            $Subscriber .= sprintf('<LastName>%s</LastName>', $LastName);
        }

        $ServiceAddress = '';
        $ServiceAddress .= sprintf('<HouseNumber>%s</HouseNumber>', $HouseNumber);
        $ServiceAddress .= sprintf('<StreetName>%s</StreetName>', $StreetName);
        $ServiceAddress .= sprintf('<City>%s</City>', $City);
        $ServiceAddress .= sprintf('<StateCode>%s</StateCode>', $StateCode);
        $ServiceAddress .= sprintf('<Zip>%s</Zip>', $Zip);
        if ($County !== null) {
            $ServiceAddress .= sprintf('<County>%s</County>', $County);
        }
        $Subscriber .= sprintf('<ServiceAddress>%s</ServiceAddress>', $ServiceAddress);

        $list .= sprintf('<Subscriber>%s</Subscriber>', $Subscriber);

        $list .= sprintf('<LoaAuthorizingPerson>%s</LoaAuthorizingPerson>', $LoaAuthorizingPerson);
        $list .= '<TnAttributes><TnAttribute>Protected</TnAttribute></TnAttributes>';

        $ListTNs = '';
        foreach ($ListOfPhoneNumbers as $tn) {
            $ListTNs .= sprintf('<PhoneNumber>%s</PhoneNumber>', $tn);
        }
        $list .= sprintf('<ListOfPhoneNumbers>%s</ListOfPhoneNumbers>', $ListTNs);
        $list .= '<Triggered>false</Triggered>';
        $list .= '<BillingType>PORTIN</BillingType>';

        return $this->submitPOSTRawRequest(
            sprintf('/accounts/%s/portins', $this->getAccountId()),
            [],
            sprintf($xml, $list)
        );
    }

    /**
     * @return object
     */
    public function sites()
    {
        return $this->submitGETRequest(
            sprintf('/accounts/%s/sites', $this->getAccountId()),
            []
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

    /**
     * @param string $Action should be: ASSIGN | UNASSIGN
     * @param string|integer $CustomerOrderId
     * @param array|integer|string $TelephoneNumbers
     * @return object
     */
    public function numbersAssignment($Action, $CustomerOrderId, $TelephoneNumbers)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
        $xml .= '<TelephoneNumbersAssignmentOrder>';
        $xml .= sprintf('<CustomerOrderId>%s</CustomerOrderId>', $CustomerOrderId);
        $xml .= sprintf('<Action>%s</Action>', $Action);
        $xml .= '<TelephoneNumbers>';
        if (is_array($TelephoneNumbers)) {
            foreach ($TelephoneNumbers as $TelephoneNumber) {
                $xml .= sprintf('<TelephoneNumber>%s</TelephoneNumber>', $TelephoneNumber);
            }
        }
        else {
            $xml .= sprintf('<TelephoneNumber>%s</TelephoneNumber>', $TelephoneNumbers);
        }
        $xml .= '</TelephoneNumbers>';
        $xml .= '</TelephoneNumbersAssignmentOrder>';

        return $this->submitPOSTRawRequest(
            sprintf('/accounts/%s/numbersAssignment', $this->getAccountId()),
            [],
            $xml
        );
    }

    /**
     * @param string|integer $CustomerOrderId
     * @param array|integer|string $TelephoneNumbers
     * @return object
     */
    public function assignNumber($CustomerOrderId, $TelephoneNumbers)
    {
        return $this->numbersAssignment('ASSIGN', $CustomerOrderId, $TelephoneNumbers);
    }

    /**
     * @param string|integer $CustomerOrderId
     * @param array|integer|string $TelephoneNumbers
     * @return object
     */
    public function unassignNumber($CustomerOrderId, $TelephoneNumbers)
    {
        return $this->numbersAssignment('UNASSIGN', $CustomerOrderId, $TelephoneNumbers);
    }

    /**
     * @param string $Name
     * @param string|integer $SiteId
     * @param string|integer $PeerId
     * @param string|integer $CustomerOrderId
     * @param array|integer|string $TelephoneNumberList
     * @param array|integer|string $ReservationIdList
     * @return object
     */
    public function orders($Name, $SiteId, $PeerId, $CustomerOrderId, $TelephoneNumberList = [], $ReservationIdList = [])
    {
        /*
<Order>
 <Name>Available Telephone Number order</Name>
 <SiteId>461</SiteId>
 <CustomerOrderId>SJMres001</CustomerOrderId>
 <ExistingTelephoneNumberOrderType>

     <TelephoneNumberList>
         <TelephoneNumber>7034343704</TelephoneNumber>
         <TelephoneNumber>5405514342</TelephoneNumber>
     </TelephoneNumberList>

     <ReservationIdList>
         <ReservationId>3150268b-b7e8-421f-8cc8-9ad9f2e8fd24</ReservationId>
         <ReservationId>8dddbd6f-77ca-4a17-97ca-83d334fc404e</ReservationId>
     </ReservationIdList>

 </ExistingTelephoneNumberOrderType>
</Order>
        */
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
        $xml .= '<Order>';
        $xml .= sprintf('<Name>%s</Name>', $Name);
        $xml .= sprintf('<SiteId>%s</SiteId>', $SiteId);
        $xml .= sprintf('<PeerId>%s</PeerId>', $PeerId);
        $xml .= sprintf('<CustomerOrderId>%s</CustomerOrderId>', $CustomerOrderId);
        $xml .= '<ExistingTelephoneNumberOrderType>';

        if (!empty($TelephoneNumberList)) {
            $xml .= '<TelephoneNumberList>';
            if (is_array($TelephoneNumberList)) {
                foreach ($TelephoneNumberList as $TelephoneNumber) {
                    $xml .= sprintf('<TelephoneNumber>%s</TelephoneNumber>', $TelephoneNumber);
                }
            } else {
                $xml .= sprintf('<TelephoneNumber>%s</TelephoneNumber>', $TelephoneNumberList);
            }
            $xml .= '</TelephoneNumberList>';
        }

        if (!empty($ReservationIdList)) {
            $xml .= '<ReservationIdList>';
            if (is_array($ReservationIdList)) {
                foreach ($ReservationIdList as $ReservationId) {
                    $xml .= sprintf('<ReservationId>%s</ReservationId>', $ReservationId);
                }
            } else {
                $xml .= sprintf('<ReservationId>%s</ReservationId>', $ReservationIdList);
            }
            $xml .= '</ReservationIdList>';
        }

        $xml .= '</ExistingTelephoneNumberOrderType>';
        $xml .= '</Order>';

        return $this->submitPOSTRawRequest(
            sprintf('/accounts/%s/orders', $this->getAccountId()),
            [],
            $xml
        );
    }

    /**
     * @param string|integer $orderid
     * @return object
     */
    public function getOrder($orderid)
    {
        return $this->submitGETRequest(
            sprintf('/accounts/%s/orders/%s', $this->getAccountId(), $orderid),
            []
        );
    }

    /**
     * @param string|integer $orderid
     * @param string $Name
     * @param string|integer $CustomerOrderId
     * @param bool $CloseOrder
     * @return object
     */
    public function order($orderid, $Name, $CustomerOrderId, $CloseOrder)
    {
        /*
<Order>
    <Name>Available Telephone Number order</Name>
    <CustomerOrderId>123456789</CustomerOrderId>
    <CloseOrder>true</CloseOrder>
</Order>
        */
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
        $xml .= '<Order>';
        $xml .= sprintf('<Name>%s</Name>', $Name);
        $xml .= sprintf('<CustomerOrderId>%s</CustomerOrderId>', $CustomerOrderId);
        $xml .= sprintf('<CloseOrder>%s</CloseOrder>', $CloseOrder ? 'true' : 'false');
        $xml .= '</Order>';

        return $this->submitPOSTRawRequest(
            sprintf('/accounts/%s/orders/%s', $this->getAccountId(), $orderid),
            [],
            $xml
        );
    }

    /**
     * @param string|integer $ReservedTn
     * @return object
     */
    public function tnreservation($ReservedTn)
    {
        /*
<Reservation>
 <ReservedTn>5405514342</ReservedTn>
</Reservation>
        */
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
        $xml .= '<Reservation>';
        $xml .= sprintf('<ReservedTn>%s</ReservedTn>', $ReservedTn);
        $xml .= '</Reservation>';

        return $this->submitPOSTRawRequest(
            sprintf('/accounts/%s/tnreservation', $this->getAccountId()),
            [],
            $xml,
            false
        );
    }

    /**
     * @param string $Name The name of the order. Max length restricted to 50 characters
     * @param array $TelephoneNumberList A list of telephone numbers to disconnect.
     * @param string $Protected Change protected status of telephones during disconnection. Optional parameter. Possible values: TRUE, FALSE, UNCHANGED. Typically UNCHANGED.
     * @return object
     */
    public function disconnects($Name, $TelephoneNumberList = [], $Protected = 'UNCHANGED')
    {
        /*
        <?xml version="1.0"?>
<DisconnectTelephoneNumberOrder>
    <name>training run</name>
    <DisconnectTelephoneNumberOrderType>
        <TelephoneNumberList>
            <TelephoneNumber>4158714245</TelephoneNumber>
            <TelephoneNumber>4352154439</TelephoneNumber>
            <TelephoneNumber>4352154466</TelephoneNumber>
        </TelephoneNumberList>
        <Protected>UNCHANGED</Protected>
    </DisconnectTelephoneNumberOrderType>
</DisconnectTelephoneNumberOrder>
        */

        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
        $xml .= '<DisconnectTelephoneNumberOrder>';
        $xml .= sprintf('<name>%s</name>', $Name);
        $xml .= '<DisconnectTelephoneNumberOrderType>';
            $xml .= '<TelephoneNumberList>';
            foreach ($TelephoneNumberList as $number) {
                $xml .= sprintf('<TelephoneNumber>%s</TelephoneNumber>', $number);
            }
            $xml .= '</TelephoneNumberList>';
            $xml .= sprintf('<Protected>%s</Protected>', $Protected);
        $xml .= '</DisconnectTelephoneNumberOrderType>';
        $xml .= '</DisconnectTelephoneNumberOrder>';

        return $this->submitPOSTRawRequest(
            sprintf('/accounts/%s/disconnects', $this->getAccountId()),
            [],
            $xml,
            false
        );
    }

}