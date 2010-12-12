<?php

namespace Bundle\GMapBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GeocoderTests extends WebTestCase
{

    public function testGeocoderLatLng()
    {
    	$address = '12 rue Hippolyte Lebas 75009 Paris France';
    	$lat = '48.8772535';
    	$lng = '2.3397612';

        $crawler = $this->createClient()->request('GET', '/_tests/GMapBundle/GeocoderLatLng/'.$address);
        $this->assertEquals($lat.','.$lng, $crawler->text());
    }

    public function testGeocoderAddress()
    {
    	$lat = '48,8772535';
        $lng = '2,3397612';
        $address = '12 Rue Hippolyte Lebas, 75009 Paris, France';

        $crawler = $this->createClient()->request('GET', '/_tests/GMapBundle/GeocoderAddress/'.$lat.'/'.$lng);
        $this->assertEquals($address, $crawler->text());
    }

}