<?php

namespace App\Tests\Controller;

use App\Controller\FinancialMovementsController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FinancialMovementsControllerTest extends WebTestCase
{

    public function testFinancialMovementsResponse()
    {
        $client = static::createClient();
        $client->request('GET', '/financial-movements');
        $this->assertResponseStatusCodeSame(200, $client->getResponse()->getStatusCode(),"Error: Request/Response Financial Movements page!");
    }

    public function testFinancialMovementsContent()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/financial-movements');
        $this->assertEquals(1,$crawler->filter('div[id="financial-movements-wrapper"]')->count(),"Error: check Financial Movements page template structure missing wrapper area!");
    }
}