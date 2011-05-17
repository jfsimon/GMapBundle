<?php

namespace GMapBundle;

use GMapBundle\Encoder\PolylineEncoder;
use GMapBundle\Webservice\Geocoder;
use GMapBundle\Webservice\Elevation;

class GMap
{

    protected
        $polylineEncoder,
        $geocoder,
        $elevation;

    public function __construct(PolylineEncoder $polylineEncoder, Geocoder $geocoder, Elevation $elevation)
    {
        $this->polylineEncoder = $polylineEncoder;
        $this->geocoder = $geocoder;
        $this->elevation = $elevation;
    }

    public function encodePolyline(array $polyline)
    {
        return $this->polylineEncoder->encode($polyline);
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

    public function elevation(array $pathOrLocations, array $options = array())
    {
        if(count($pathOrLocations) == 3 && is_int($pathOrLocations[2])) {
            return $this->elevation->pathElevation($pathOrLocations[0], $pathOrLocations[1], $pathOrLocations[2], $options);
        }

        return $this->elevation->locationsElevation($pathOrLocations, $options);
    }

}