<?php

namespace App\Tests\Controller;

use App\Controller\HomeController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
	public function testHomeResponse()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(200, $client->getResponse()->getStatusCode(), "Error: Request/Response Home page!");
    }

    public function testHomeContent()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertEquals(1,$crawler->filter('div[id="home-wrapper"]')->count(),"Error: check Home page template structure missing wrapper area!");
    }
}