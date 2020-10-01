<?php

namespace App\Controller;

use App\Repository\FinancialMovementsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FinancialMovementsController extends AbstractController
{
     /**
     * @param FinancialMovementsRepository $repository
     *
     * @Route("/financial-movements", name="financial_movements", methods={"GET","HEAD"})
     */
	public function index(FinancialMovementsRepository $financialMovementsRepository, Request $request)
    {
        $wallet_id = $request->get('walletId');
        if ($wallet_id) {
            $financialMovements = $financialMovementsRepository->findMovementByWallet($wallet_id);
        } else {
            $financialMovements = $financialMovementsRepository->findAll();
        }

        return $this->render('financial_movements/index.html.twig', compact('financialMovements'));
    }
}
