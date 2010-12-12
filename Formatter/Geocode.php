<?php

namespace Bundle\GMapBundle\Formatter;

class Geocode
{

    public function __construct(array $data)
    {
        $this->data = $data['results'][0];
    }

    public function getLat()
    {
        return (float)$this->data['geometry']['location']['lat'];
    }

    public function getLng()
    {
        return (float)$this->data['geometry']['location']['lng'];
    }

    public function getLatLng($array = true)
    {
        if($array) {
            return array($this->getLat(), $this->getLng());
        } else {
            return $this->getLat().','.$this->getLng();
        }
    }

    public function getAddress($array = false)
    {
        return $this->data['formatted_address'];
    }

}