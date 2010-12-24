<?php

namespace Bundle\GMapBundle;

use Bundle\GMapBundle\Encoder\PolylineEncoder;
use Bundle\GMapBundle\Webservice\Geocoder;
use Bundle\GMapBundle\Webservice\Elevation;
use Bundle\GMapBundle\Webservice\Directions;

class GMap
{

    protected
        $polylineEncoder,
        $geocoder,
        $elevation,
        $directions;

    public function __construct(PolylineEncoder $polylineEncoder, Geocoder $geocoder, Elevation $elevation, Directions $directions)
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

    public function directions($origin, $destination, array $array1 = array(), array $array2 = array())
    {
        $waypoints = array();
        $parameters = array();

        if(count($array1)) {
            if($this->isNumericArray($array1)) {
                $waypoints = $array1;
            } else {
                $parameters = $array1;
            }
        }

        if(count($array2)) {
            if($this->isNumericArray($array2)) {
                $waypoints = $array2;
            } else {
                $parameters = $array2;
            }
        }

        if(count($waypoints)) {
            return $this->directions->waypointsDirections($origin, $destination, $waypoints, $parameters);
        }

        return $this->directions->directions($origin, $destination, $parameters);
    }

    protected function isNumericArray(array $array)
    {
        return array_keys($array) == range(0, count($array) - 1);
    }

}