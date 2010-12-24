<?php

namespace Bundle\GMapBundle\Formatter;

use Bundle\GMapBundle\Formatter\Formatter;
use Bundle\GMapBundle\Formatter\LocationInterface;

class Elevation extends Formatter implements \Iterator, LocationInterface
{

    public function getLat()
    {
        return $this->result['location']['lat'];
    }

    public function getLng()
    {
        return $this->result['location']['lat'];
    }

    public function getLatLng($array = false)
    {
        if($array) {
            return array($this->getLat(), $this->getLng());
        } else {
            return $this->getLat().','.$this->getLng();
        }
    }

    public function __toString()
    {
        return $this->getLatLng(false);
    }

    public function getElevation()
    {
        return $this->result['elevation'];
    }

}