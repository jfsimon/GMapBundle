<?php

namespace GMapBundle\Controller;

use GMapBundle\Formatter;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use GMapBundle\Formatter\PolylineEncoder;
use GMapBundle\Webservice\Elevation;

class TestsController extends Controller
{

    public function serviceExistsAction()
    {
        return $this->createResponse($this->has('g_map') ? 'yes' : 'no');
    }

    public function serviceClassAction()
    {
        return $this->createResponse(get_class($this->get('g_map')));
    }

    public function geocoderAddress1Action($address)
    {
        $result = $this->get('g_map')->geocode($address);
        $result = $this->getFirstStreetAddress($result);
        return $this->createResponse($result->getLatLng(false));
    }

    public function geocoderAddress2Action($address)
    {
        $result = $this->get('g_map')->geocode($address);
        $result = $this->getFirstStreetAddress($result);
        return $this->createResponse(implode("\n", $result->getLatLng(true)));
    }

    public function geocoderLatLng1Action($lat, $lng)
    {
        $result = $this->get('g_map')->geocode(array($lat, $lng));
        $result = $this->getFirstStreetAddress($result);
        return $this->createResponse($result->getAddress());
    }

    public function geocoderLatLng2Action($lat, $lng)
    {
        $result = $this->get('g_map')->geocode(array($lat, $lng));
        $result = $this->getFirstStreetAddress($result);
        return $this->createResponse($result->getAddress(true));
    }

    public function geocoderLatLng3Action($latLng)
    {
        $result = $this->get('g_map')->geocode($latLng);
        $result = $this->getFirstStreetAddress($result);
        return $this->createResponse($result->getAddress());
    }

    public function geocoderComponents1Action($address)
    {
        $result = $this->get('g_map')->geocode($address);
        $result = $this->getFirstStreetAddress($result);
        return $this->createResponse(implode("\n", array(
            $result->getAddressComponent('street_number'),
            $result->getAddressComponent('route'),
            $result->getAddressComponent('postal_code'),
            $result->getAddressComponent('locality'),
            $result->getAddressComponent('country'),
        )));
    }

    public function geocoderComponents2Action($address)
    {
        $result = $this->get('g_map')->geocode($address);
        $result = $this->getFirstStreetAddress($result);
        return $this->createResponse(implode("\n", array(
            $result->getAddressComponent('administrative_area_level_1'),
            $result->getAddressComponent('administrative_area_level_2'),
            $result->getAddressComponent('sublocality'),
        )));
    }

    public function geocoderComponents3Action($address)
    {
        $result = $this->get('g_map')->geocode($address);
        $result = $this->getFirstStreetAddress($result);
        return $this->createResponse(implode("\n", array(
            $result->getAddressComponent('country', true),
            $result->getAddressComponent('administrative_area_level_1', true),
            $result->getAddressComponent('administrative_area_level_2', true),
        )));
    }

    public function polylineEncoderAction()
    {
        $polyline = array(
            array(48.8772535, 2.3397612),
            array(45.8772535, 3.3397612),
            array(43.8772535, 5.3397612),
            array(42.8772535, 8.3397612),
        );
        $encoded = $this->get('g_map')->encodePolyline($polyline);
        return $this->createResponse($encoded['points']."\n".$encoded['levels']);
    }

    public function elevationIterationAction()
    {
        $points = array(
            array(48.8772535, 2.3397612),
            array(45.8772535, 3.3397612),
            array(43.8772535, 5.3397612),
            array(42.8772535, 8.3397612),
        );
        $result = array();
        foreach($this->get('g_map')->elevation($points) as $elevation) {
            $result[] = $elevation->getElevation();
        }
        return $this->createResponse(implode("\n", $result));
    }



    protected function getFirstStreetAddress($result)
    {
        if($result->isCollection()) {
            return $result->filterType('street_address')->getOne(0);
        }
        return $result;
    }

    private function createResponse($response)
    {
        return new Response($response);

    }

}
