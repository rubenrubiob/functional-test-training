<?php

namespace rubenrubiob\WebserviceBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * Class PoemControllerTest
 * @package rubenrubiob\WebserviceBundle\Tests\Controller
 */
class PoemControllerTest extends WebTestCase
{
    private $client;
    private $currentStatusCode;
    private $currentResponse;

    /**
     * Load initial data
     */
    public function setUp()
    {
        // Load empty fixtures
        $this->loadFixtures(array());
        $this->client = static::createClient();
    }

    /**
     * Test all method
     */
    public function testAll()
    {
        // 1. Request: empty response

        $this->makeRequest('GET', '/webservices/poems/');

        $this->assertEquals(200, $this->currentStatusCode);
        $this->assertEquals(true, empty($this->currentResponse));
        $this->assertEquals(false, array_key_exists('poems', $this->currentResponse));


        // Load fixtures
        $this->loadFixtures(array(
            'rubenrubiob\PoemBundle\DataFixtures\ORM\LoadPoemData',
        ));


        // 2. Request: response with eight elements

        $this->makeRequest('GET', '/webservices/poems/');

        $this->assertEquals(200, $this->currentStatusCode);
        $this->assertEquals(false, empty($this->currentResponse));
        $this->assertEquals(true, array_key_exists('poems', $this->currentResponse));
        $this->assertEquals(8, count($this->currentResponse['poems']));

        // Check required fields for each poem
        foreach ($this->currentResponse['poems'] as $poem) {
            $this->assertEquals(true, array_key_exists('title', $poem));
            $this->assertEquals(true, array_key_exists('artist', $poem));
            $this->assertEquals(true, is_array($poem['artist']));
            $this->assertEquals(false, empty($poem['artist']));
            $this->assertEquals(true, array_key_exists('name', $poem['artist']));
        }
    }

    /**
     * @param $method
     * @param $url
     */
    private function makeRequest($method, $url)
    {
        $this->client->request($method, $url);
        $response = $this->client->getResponse();

        //Save the status code to check it afterwards
        $this->currentStatusCode = $response->getStatusCode();
        $this->currentResponse = json_decode($response->getContent(), true);

        $this->client->restart();
    }
}
