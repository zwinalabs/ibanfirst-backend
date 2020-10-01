<?php

namespace App\Controller;

use App\Repository\WalletRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Middleware\WsseAuth;

class WalletsController extends AbstractController
{
    /**
     * @var WsseAuth
     */
    private $wsseAuth;
    /**
     * @var ParameterBagInterface
     */
    private $parameterBag;

    /**
     * Constructor.
     *
     * @param WsseAuth    $wsseAuth
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(WsseAuth $wsseAuth, ParameterBagInterface $parameterBag)
    {
        $this->wsseAuth = $wsseAuth;
        $this->parameterBag = $parameterBag;
    }

    /**
     * Index : Controller action of Wallet Index page
     *
     * @param WalletRepository $repository
     * @Route("/wallets", name="wallets", methods={"GET","HEAD"})
     */
    public function index(WalletRepository $repository)
    {
        $wallets = $repository->findAll();
        return $this->render('wallets/index.html.twig',compact('wallets'));
    }
}
