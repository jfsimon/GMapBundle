<?php

namespace Bundle\GMapBundle\Webservice;

use Bundle\GMapBundle\Webservice\Webservice;

class Directions extends Webservice
{

    const MODE_DRIVING = 'driving';
    const MODE_WALKING = 'walking';
    const MODE_BICYCLING = 'bicycling';

    const AVOID_TOLLS = 'tolls';
    const AVOID_HIGHWAYS = 'highways';

    const UNITS_METRIC = 'metric';
    const UNITS_IMPERIAL = 'imperial';

    protected function setup()
    {
        $this->responseNamespace = 'routes';
    }

    public function directions($origin, $destination, array $parameters = array())
    {
        return $this->call(array_merge($parameters, array(
            'origin' => $this->formatLocation($origin),
            'destination' => $this->formatLocation($destination),
        )));
    }

    public function waypointsDirections($origin, $destination, array $waypoints, array $parameters = array())
    {
        return $this->call(array_merge($parameters, array(
            'origin' => $this->formatLocation($origin),
            'destination' => $this->formatLocation($destination),
            'waypoints' => $this->formatWaypoints($waypoints),
        )));
    }

    protected function formatLocation($location)
    {
        if(is_array($location) && count($location) > 1) {
            $location = $location[0].','.$location[1];
        } else {
            $location = (string)$location;
        }

        return urlencode($location);
    }

    protected function formatWaypoints(array $waypoints, $optimize = true)
    {
        $locations = array();

        foreach($waypoints as $waypoint) {
            $locations[] = $this->formatLocation($waypoint);
        }

        return ($optimize ? 'optimize:true|' : '').implode('|', $locations);
    }

}