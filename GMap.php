<?php

namespace Bundle\GMapBundle;

use Bundle\GMapBundle\Webservice\Geocoder;

class GMap
{

    protected $geocoder;

    public function __construct(Geocoder $geocoder)
    {
        $this->geocoder = $geocoder;
    }

    public function geocode($place, array $parameters = array())
    {
        if(is_string($place)) {
            $place = trim($place);

            $matches = null;
            if(preg_match('/^([0-9.]+) *, *([0-9.]+)$/', $place, $matches) > 1) {
                return $this->geocoder->geocodeLatLng($matches[1], $matches[2], $parameters);
            }

            return $this->geocoder->geocodeAddress($place, $parameters);

        } else if(is_array($place) && count($place) > 1) {
            return $this->geocoder->geocodeLatLng($place[0], $place[1], $parameters);
        }

        throw new \Exception('Wrong source parameter');
    }

}