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

    public function geocode($source, array $parameters = array())
    {
        if(is_string($source)) {
            $source = trim($source);

//            if(preg_match('^[0-9.]+ *, *[0-9.]+$', $source, $matches)) {
//                return $this->geocoder->geocodeLatLng($matches[0], $matches[1], $parameters);
//            }

            return $this->geocoder->geocodeAddress($source, $parameters);
        } else if(is_array($source) && count($source) > 1) {
            return $this->geocoder->geocodeLatLng($source[0], $source[1], $parameters);
        }
        throw new \Exception('Wrong source parameter');
    }

}