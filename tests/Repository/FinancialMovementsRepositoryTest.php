<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FinancialMovementsRepositoryTest extends WebTestCase
{

    public function setUp()
    {
        self::bootKernel();
        $this->repository = self::$container->get('financial_movements_repository');
    }

    public function testFindAll()
    {
        $this->assertTrue(count($this->repository->findAll()) > 0 , "No data Financial Movements from API received!");
    }

    public function testValidateFinancialMovements()
    {
        $financialMovements = $this->repository->findAll();
        $this->assertInstanceOf(\App\Entity\FinancialMovements::class,$financialMovements[0] , "No data Financial Movements from API received!");
    }
}