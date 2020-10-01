<?php

namespace App\Repository;

use App\Entity\Wallet;
use App\Entity\FinancialMovements;
use App\Middleware\WsseAuth;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


/**
 * @method FinancialMovements|null find($id, $lockMode = null, $lockVersion = null)
 * @method FinancialMovements|null findOneBy(array $criteria, array $orderBy = null)
 * @method FinancialMovements[]    findAll()
 * @method FinancialMovements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FinancialMovementsRepository
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
    /**
     * @var WalletRepository
     */
    private $walletRepository;

    /**
     * Constructor
     *
     * @param WsseAuth $wsseAuth
     * @param ParameterBagInterface $parameterBag
     * @param LoggerInterface $logger
     * @param WalletRepository $repository
     */
    public function __construct(WsseAuth $wsseAuth, ParameterBagInterface $parameterBag, LoggerInterface $logger, WalletRepository $repository)
    {
        $this->wsseAuth = $wsseAuth;
        $this->parameterBag = $parameterBag;
        $this->logger = $logger;
        $this->walletRepository = $repository;
    }

    /**
    * @return FinancialMovements[] Returns an array of FinancialMovements objects
    */
    public function findAll(): array
    {
        // get api base url
        $base_api_url = $this->parameterBag->get('BASE_API_URL');
        // get all financialMovements
        $financial_mouvements = $this->wsseAuth->getContent($base_api_url .DIRECTORY_SEPARATOR. 'financialMovements/');
        if (!isset($financial_mouvements['financialMovements']) or !is_array($financial_mouvements['financialMovements'])) {
            $this->logger->error("No 'financial movements' data received");
            return [];
        }
        $wallets = $this->walletRepository->findAll();
        $financial_mouvements_for_wallet = [];
        // search all movement for current wallet
        // echo "<pre>";var_dump($financial_mouvements);exit;
        foreach ($financial_mouvements['financialMovements'] as $movement) {
            // create amount object
            $valueAmount = null;
            if (isset($movement['amount'])) {
                // valueAmount(value, currency) object
                $valueAmount = new \stdClass();
                $valueAmount->value = $movement['amount']['value'];
                $valueAmount->currency = $movement['amount']['currency'];     
            }
            // create financial movement object
            $wallet = $this->searchWallet($movement['walletId']??null, $wallets);
            $financial_mouvements_for_wallet[] = (new FinancialMovements())
                ->setId($movement['id']??null)
                ->setBookingDate(new \DateTime($movement['bookingDate']))
                ->setValueDate(new \DateTime($movement['valueDate']))
                ->setDescription($movement['description']??null)
                ->setWallet($wallet)
                ->setAmount($valueAmount);
        }
        unset($wallets);
        return $financial_mouvements_for_wallet;
    }

    /**
     * searchWallet : get wallet for single financial movment
     *
     * @param  string|null $id
     * @param  array       $wallets
     * @return Wallet|null
     */
    private function searchWallet(?string  $id, array $wallets):?Wallet
    {
        foreach ($wallets as $wallet) {
            if (strtolower($id) == strtolower($wallet->getId())) {
                return $wallet;
            }
        }
        return null;
    }

    /**
     * findMovementByWallet : search financial movement by wallet.id
     *
     * @param  string $id
     * @return array
     */
    public function findMovementByWallet(string $id):array
    {
        $movements = [];
        foreach ($this->findAll() as $movement) {
            // if wallet is not null and the id of the wallet equal $id
            if (!is_null($movement->getWallet()) && strtolower($movement->getWallet()->getId()) == strtolower($id)) {
                $movements[] = $movement;
            }
        }
        return $movements;
    }


}
