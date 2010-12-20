<?php

namespace Bundle\GMapBundle\Webservice;

use Bundle\GMapBundle\Webservice\Webservice;

class Geocoder extends Webservice
{

    public function geocodeAddress($address, array $parameters = array())
    {
        return $this->call(array_merge($parameters, array(
            'address' => urlencode($address),
        )));
    }

    public function geocodeLatLng($lat, $lng, array $parameters = array())
    {
        return $this->call(array_merge($parameters, array(
            'latlng' => $lat.','.$lng,
        )));
    }

}