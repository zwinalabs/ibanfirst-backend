<?php

namespace App\Controller;

use App\Middleware\WsseAuth;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
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
    * @var LoggerInterface
    */
    private $logger;

    public function __construct(WsseAuth $wsseAuth, ParameterBagInterface $parameterBag, LoggerInterface $logger)
	{
		$this->wsseAuth = $wsseAuth;
		$this->parameterBag = $parameterBag;
		$this->logger = $logger;
	}
	/**
    * @Route("/", name="home", methods={"GET","HEAD"})
    */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
