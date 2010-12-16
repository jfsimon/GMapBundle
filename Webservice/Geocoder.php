<?php

namespace Bundle\GMapBundle\Webservice;

use Bundle\GMapBundle\Webservice\Webservice;
use Bundle\GMapBundle\Formatter\Geocode;

class Geocoder extends Webservice
{

    public function geocodeAddress($address, array $parameters = array())
    {
        return new Geocode($this->getData(array_merge($parameters, array(
            'address' => $address,
        ))));
    }

    public function geocodeLatLng($lat, $lng, array $parameters = array())
    {
        return new Geocode($this->getData(array_merge($parameters, array(
            'latlng' => $lat.','.$lng,
        ))));
    }

    protected function getDefaultParameters()
    {
        return array(
            'sensor' => $this->options['sensor'] ? 'true' : 'false',
            'region' => $this->options['region'],
            'language' => $this->options['language'],
            'bounds' => $this->options['bounds'],
        );
    }

}