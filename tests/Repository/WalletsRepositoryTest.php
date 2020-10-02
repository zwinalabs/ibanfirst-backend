<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WalletsRepositoryTest extends WebTestCase
{

    public function setUp()
    {
        self::bootKernel();
        $this->repository = self::$container->get('wallet_repository');
    }

    public function testFindAll()
    {
        $this->assertTrue(count($this->repository->findAll()) > 0 , "No data Wallets from API received!");
    }

    public function testValidateWallets()
    {
        $wallets = $this->repository->findAll();
        $this->assertInstanceOf(\App\Entity\Wallet::class,$wallets[0] , "No data Wallets from API received!");
    }
}