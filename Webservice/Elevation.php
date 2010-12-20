<?php

namespace Bundle\GMapBundle\Webservice;

use Bundle\GMapBundle\Webservice\Webservice;

class Elevation extends Webservice
{

    public function locationsElevation(array $locations, array $parameters = array())
    {
        return $this->call(array_merge($parameters, array(
            'locations' => $this->encodePolyline($locations),
        )));
    }

    public function pathElevation(array $start, array $end, $samples, array $parameters = array())
    {
        return $this->call(array_merge($parameters, array(
            'path' => $this->encodePolyline(array($start, $end)),
            'samples' => $samples,
        )));
    }

}