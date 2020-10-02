<?php

namespace App\Tests\Middleware;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WsseAuthTest extends WebTestCase
{

    private $middleware;

    public function setUp()
    {
        self::bootKernel();
        $this->middleware = self::$container->get('wsse_middleware');
    }

    public function testGetContent()
    {
        $base_api_url = self::$container->getParameter('BASE_API_URL');
        $data = $this->middleware->getContent($base_api_url.DIRECTORY_SEPARATOR.'wallets'.DIRECTORY_SEPARATOR);
        $this->assertTrue(count($data) > 0);
    }

    public function testAttach()
    {
        $header = $this->middleware->attach();
        $this->assertTrue(count($header) > 0,"The WSSE header is not valid");
        $this->assertRegExp("/^X-WSSE: UsernameToken Username/",$header[0],"The WSSE header (UsernameToken Username) is not valid");
        $this->assertRegExp("/^Content-Type: application\/json$/",$header[1],"The WSSE header type(application/json) is not valid");
    }

    public function testGetContentWithFalseAPIParams()
    {
        $base_api_url = self::$container->getParameter('BASE_API_URL');
        $data = $this->middleware->getContent($base_api_url.DIRECTORY_SEPARATOR. 'iBanFirstInvalidUrl'.DIRECTORY_SEPARATOR);
        $this->assertTrue(count($data) == 0);
    }
}
