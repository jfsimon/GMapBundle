<?php

namespace GMapBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ServiceTests extends WebTestCase
{

    public function testServiceExists()
    {
        $crawler = $this->createClient()->request('GET', '/_tests/GMapBundle/ServiceExists');
        $this->assertEquals('yes', $crawler->text());
    }

    public function testServiceClass()
    {
        $crawler = $this->createClient()->request('GET', '/_tests/GMapBundle/ServiceClass');
        $this->assertEquals('Bundle\GMapBundle\GMap', $crawler->text());
    }

}