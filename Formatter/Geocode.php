<?php

namespace GMapBundle\Formatter;

use GMapBundle\Formatter\Formatter;

class Geocode extends Formatter implements \Iterator
{

    protected $address;

    public function getLat()
    {
        return (float)$this->result['geometry']['location']['lat'];
    }

    public function getLng()
    {
        return (float)$this->result['geometry']['location']['lng'];
    }

    public function getLatLng($array = false)
    {
        if($array) {
            return array($this->getLat(), $this->getLng());
        } else {
            return $this->getLat().','.$this->getLng();
        }
    }

    public function getAddress()
    {
        return $this->result['formatted_address'];
    }

    public function getTypes()
    {
        return $this->result['types'];
    }

    public function getAddressComponents($shortcut = false)
    {
        $this->parseAddress();
        $components = array();

        foreach($this->address as $component => $value) {
            $array = $this->address[$component][$shortcut ? 'short' : 'long'];
            $components[$component] = count($array) == 1 ? $array[0] : $array;
        }

        return $components;
    }

    public function getAddressComponent($component, $shortcut = false)
    {
        $this->parseAddress();

        if(isset($this->address[$component])) {
            $array = $this->address[$component][$shortcut ? 'short' : 'long'];
            return count($array) == 1 ? $array[0] : $array;
        }

        return null;
    }

    protected function parseAddress()
    {
        if(is_array($this->address)) {
            return;
        }

        $this->address = array();

        foreach($this->result['address_components'] as $component) {
            foreach($component['types'] as $type) {
                if(! isset($this->address[$type])) {
                    $this->address[$type] = array(
                        'long' => array(),
                        'short' => array()
                    );
                }
                $this->address[$type]['long'][] = $component['long_name'];
                $this->address[$type]['short'][] = $component['short_name'];
            }
        }
    }

}