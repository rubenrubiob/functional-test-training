<?php

namespace rubenrubiob\WebBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * Class PoemControllerTest
 * @package rubenrubiob\WebBundle\Tests\Controller
 */
class PoemControllerTest extends WebTestCase
{
    /**
     * Test all method
     */
    public function testAll()
    {
        // Load empty fixtures
        $this->loadFixtures(array());

        $client = static::makeClient();

        $crawler = $client->request('GET', '/web/poems/');

        // There should be the message 'No poems found'
        $this->assertEquals(true, $crawler->filter('html:contains("No poems found")')->count() > 0);


        // Load fixtures
        $this->loadFixtures(array(
            'rubenrubiob\PoemBundle\DataFixtures\ORM\LoadPoemData',
        ));

        $crawler = $client->request('GET', '/web/poems/');

        // Check that there are 8 poem titles, 8 poem years and 8 author names
        $this->assertEquals(8, $crawler->filter('li.poem-title')->count());
        $this->assertEquals(8, $crawler->filter('li.poem-year')->count());
        $this->assertEquals(8, $crawler->filter('li.author-name')->count());
    }
}
