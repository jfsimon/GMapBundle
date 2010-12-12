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

    public function geocoderLatLngAction($address)
    {
        $geocoder = $this->get('gmap')->geocode($address);
        return $this->createResponse($geocoder->getLatLng(false));
    }

    public function geocoderAddressAction($lat, $lng)
    {
        $lat = str_replace(',', '.', $lat);
        $lng = str_replace(',', '.', $lng);

        $geocoder = $this->get('gmap')->geocode(array($lat, $lng));
        return $this->createResponse($geocoder->getAddress(false));
    }

}
