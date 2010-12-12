<?php

namespace Bundle\GMapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestsController extends Controller
{

    public function serviceExistsAction()
    {
        return $this->createResponse($this->has('gmap') ? 'yes' : 'no');
    }

    public function serviceClassAction()
    {
        return $this->createResponse(get_class($this->get('gmap')));
    }

    public function geocoderAddress1Action($address)
    {
        $geocoder = $this->get('gmap')->geocode($address);
        return $this->createResponse($geocoder->getLatLng(false));
    }

    public function geocoderAddress2Action($address)
    {
        $geocoder = $this->get('gmap')->geocode($address);
        return $this->createResponse(implode("\n", $geocoder->getLatLng(true)));
    }

    public function geocoderLatLng1Action($lat, $lng)
    {
        $geocoder = $this->get('gmap')->geocode(array($lat, $lng));
        return $this->createResponse($geocoder->getAddress());
    }

    public function geocoderLatLng2Action($lat, $lng)
    {
        $geocoder = $this->get('gmap')->geocode(array($lat, $lng));
        return $this->createResponse($geocoder->getAddress(true));
    }

    public function geocoderLatLng3Action($latLng)
    {
        $geocoder = $this->get('gmap')->geocode($latLng);
        return $this->createResponse($geocoder->getAddress());
    }

    public function geocoderComponents1Action($address)
    {
        $geocoder = $this->get('gmap')->geocode($address);
        return $this->createResponse(implode("\n", array(
            $geocoder->getAddressComponent('street_number'),
            $geocoder->getAddressComponent('route'),
            $geocoder->getAddressComponent('postal_code'),
            $geocoder->getAddressComponent('locality'),
            $geocoder->getAddressComponent('country'),
        )));
    }

    public function geocoderComponents2Action($address)
    {
        $geocoder = $this->get('gmap')->geocode($address);
        return $this->createResponse(implode("\n", array(
            $geocoder->getAddressComponent('administrative_area_level_1'),
            $geocoder->getAddressComponent('administrative_area_level_2'),
            $geocoder->getAddressComponent('sublocality'),
        )));
    }

    public function geocoderComponents3Action($address)
    {
        $geocoder = $this->get('gmap')->geocode($address);
        return $this->createResponse(implode("\n", array(
            $geocoder->getAddressComponent('country', true),
            $geocoder->getAddressComponent('administrative_area_level_1', true),
            $geocoder->getAddressComponent('administrative_area_level_2', true),
        )));
    }

}
