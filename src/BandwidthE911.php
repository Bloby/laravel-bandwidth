<?php

namespace Bandwidth;

class BandwidthE911 extends BandwidthE911Core
{
    /**
     * Instantiate a new instance
     */
    public function __construct()
    {
        parent::__construct();
    }

/*
<validateLocation>
    <location>
        <address1>2040 Larimer</address1>
        <community>Denver</community>
        <state>CO</state>
        <postalcode>80205</postalcode>
        <type>ADDRESS</type>
    </location>
</validateLocation>
*/
    /**
     * @param string $address1
     * @param string $community
     * @param string $state
     * @param integer|string $postalcode
     * @param string $type
     * @return object
     */
    public function validateLocation($address1, $community, $state, $postalcode, $type = 'ADDRESS')
    {
        return $this->_handleQuery(__FUNCTION__, compact(['address1','community','state','postalcode','type']));
    }

/*
<addLocation>
    <uri>
        <callername>Bandwidth Support</callername>
        <uri>13032288888</uri>
    </uri>
    <location>
        <address1>2040 Larimer</address1>
        <callername>Bandwidth Support</callername>
        <community>Denver</community>
        <postalcode>80201</postalcode>
        <state>CO</state>
        <type>ADDRESS</type>
    </location>
</addLocation>
*/
    public function addLocation($parameters)
    {
        return $this->_handleQuery(__FUNCTION__, $parameters);
    }
}