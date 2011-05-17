<?php

namespace GMapBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GeocoderTests extends WebTestCase
{

    public function testGeocoderAddress1()
    {
    	$address = urlencode('12 rU hipOLYte lBAs 75009 fR');
    	$lat = '48.8772535';
    	$lng = '2.3397612';

        $crawler = $this->createClient()->request('GET', '/_tests/GMapBundle/GeocoderAddress1/'.$address);
        $this->assertEquals($lat.','.$lng, $crawler->text());
    }

    public function testGeocoderAddress2()
    {
        $address = urlencode('12 rU hipOLYte lBAs 75009 fR');
        $lat = '48.8772535';
        $lng = '2.3397612';

        $crawler = $this->createClient()->request('GET', '/_tests/GMapBundle/GeocoderAddress2/'.$address);
        $this->assertEquals($lat."\n".$lng, $crawler->text());
    }

    public function testGeocoderLatLng1()
    {
    	$lat = '48%2E8772535';
        $lng = '2%2E3397612';
        $address = '12 Rue Hippolyte Lebas, 75009 Paris, France';

        $crawler = $this->createClient()->request('GET', '/_tests/GMapBundle/GeocoderLatLng1/'.$lat.'/'.$lng);
        $this->assertEquals($address, $crawler->text());
    }

    public function testGeocoderLatLng2()
    {
        $lat = '48%2E8772535';
        $lng = '2%2E3397612';
        $address = "12 Rue Hippolyte Lebas, 75009 Paris, France";

        $crawler = $this->createClient()->request('GET', '/_tests/GMapBundle/GeocoderLatLng2/'.$lat.'/'.$lng);
        $this->assertEquals($address, $crawler->text());
    }

    public function testGeocoderLatLng3()
    {
        $lat = '48%2E8772535';
        $lng = '2%2E3397612';
        $address = '12 Rue Hippolyte Lebas, 75009 Paris, France';

        $crawler = $this->createClient()->request('GET', '/_tests/GMapBundle/GeocoderLatLng3/'.$lat.','.$lng);
        $this->assertEquals($address, $crawler->text());
    }

    public function testGeocoderComponents1()
    {
        $address = urlencode('12 Rue Hippolyte Lebas, 75009 Paris, France');
        $number = '12';
        $street = 'Rue Hippolyte Lebas';
        $zipcode = '75009';
        $city = 'Paris';
        $country = 'France';

        $crawler = $this->createClient()->request('GET', '/_tests/GMapBundle/GeocoderComponents1/'.$address);
        $this->assertEquals($number."\n".$street."\n".$zipcode."\n".$city."\n".$country, $crawler->text());
    }

    public function testGeocoderComponents2()
    {
        $address = urlencode('12 Rue Hippolyte Lebas, 75009 Paris, France');
        $region = 'Ile-de-France';
        $department = 'Paris';
        $sublocality = '9ème Arrondissement Paris';

        $crawler = $this->createClient()->request('GET', '/_tests/GMapBundle/GeocoderComponents2/'.$address);
        $this->assertEquals($region."\n".$department."\n".$sublocality, $crawler->text());
    }

    public function testGeocoderComponents3()
    {
        $address = urlencode('12 Rue Hippolyte Lebas, 75009 Paris, France');
        $country = 'FR';
        $region = 'IDF';
        $department = '75';

        $crawler = $this->createClient()->request('GET', '/_tests/GMapBundle/GeocoderComponents3/'.$address);
        $this->assertEquals($country."\n".$region."\n".$department, $crawler->text());
    }

}