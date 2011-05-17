<?php

namespace GMapBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PolylineEncoderTests extends WebTestCase
{

    public function testPolylineEncoder()
    {
        $points = 'yiiiHo~gM~|hQ_ibE~reK_seK~hbE_}hQ';
        $levels = 'BBBB';

    	$crawler = $this->createClient()->request('GET', '/_tests/GMapBundle/PolylineEncoder');
        $this->assertEquals($points."\n".$levels, $crawler->text());
    }

}