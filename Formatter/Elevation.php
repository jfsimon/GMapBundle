<?php

namespace GMapBundle\Formatter;

use GMapBundle\Formatter\Formatter;

class Elevation extends Formatter implements \Iterator
{

    public function getLat()
    {
        return $this->result['location']['lat'];
    }

    public function getLng()
    {
        return $this->result['location']['lat'];
    }

    public function getLatLng()
    {
        return array($this->getLat(), $this->getLng());
    }

    public function getElevation()
    {
        return $this->result['elevation'];
    }

}