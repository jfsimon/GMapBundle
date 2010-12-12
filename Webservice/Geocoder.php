<?php

namespace Bundle\GMapBundle\Webservice;

use Bundle\GMapBundle\Webservice\Webservice;
use Bundle\GMapBundle\Formatter\Geocode;

class Geocoder extends Webservice
{

    protected $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function geocodeAddress($address, array $parameters = array())
    {
        return $this->call(array_merge($parameters, array('address' => $address)));
    }

    public function geocodeLatLng($lat, $lng, array $parameters = array())
    {
        return $this->call(array_merge($parameters, array('latlng' => $lat.','.$lng)));
    }

    protected function call(array $parameters)
    {
        $data = $this->getData(
            $this->options['url'].'/'.$this->options['format'],
            array_merge($this->getDefaultParameters(), $parameters),
            $this->options['format']
        );

        return new Geocode($data);
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