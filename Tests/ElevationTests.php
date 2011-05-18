<?php

namespace GMapBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ElevationTests extends WebTestCase
{

    public function testElevationIteration()
    {
        $elevations = array(
            37.4347992,
            290.4120789,
            213.9274139,
            -2666.8049316,
        );
    	$crawler = $this->createClient()->request('GET', '/_tests/GMapBundle/ElevationIteration');
        $this->assertEquals(implode("\n", $elevations), $crawler->text());
    }

}