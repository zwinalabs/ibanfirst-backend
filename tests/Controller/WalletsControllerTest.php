<?php

namespace App\Tests\Controller;

use App\Controller\WalletsController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WalletsControllerTest extends WebTestCase
{    
    public function testWalletsResponse()
    {
        $client = static::createClient();
        $client->request('GET', '/wallets');
        $this->assertResponseStatusCodeSame(200, $client->getResponse()->getStatusCode(),"Error: Request/Response Wallets page!");
    }

    public function testWalletsContent()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/wallets');
        $this->assertEquals(1,$crawler->filter('div[id="wallets-wrapper"]')->count(),"Error: check Wallets page template structure missing wrapper area!");
    }
}