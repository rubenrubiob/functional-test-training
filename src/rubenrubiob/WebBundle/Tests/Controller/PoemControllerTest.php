<?php

namespace rubenrubiob\WebBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class PoemControllerTest extends WebTestCase
{
    public function testAll()
    {
        $this->loadFixtures(array());

        $client = static::makeClient();


        $crawler = $client->request('GET', '/web/poems/all/');

        $this->assertEquals(true, $crawler->filter('html:contains("No poems found")')->count() > 0);


        $this->loadFixtures(array(
            'rubenrubiob\PoemBundle\DataFixtures\ORM\LoadPoemData',
        ));

        $crawler = $client->request('GET', '/web/poems/all/');

        $this->assertEquals(true, $crawler->filter('html:contains("Title:")')->count() > 0);
    }
}
