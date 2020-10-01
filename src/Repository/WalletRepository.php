<?php

namespace App\Repository;

use App\Entity\Wallet;
use App\Entity\FinancialMovements;
use App\Middleware\WsseAuth;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


/**
 * @method Wallet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wallet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wallet[]    findAll()
 * @method Wallet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WalletRepository
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
    * @return Wallet[]: return an array of Wallets objects
    */
    public function findAll(): array
    {
        // Get API url parameter file
        $baseApiUrl = $this->parameterBag->get('BASE_API_URL');
        // Get wallets via API
        $wallets = $this->wsseAuth->getContent($baseApiUrl .DIRECTORY_SEPARATOR. 'wallets/');
        //echo "<pre>";var_dump($wallets);exit;
        if (!isset($wallets['wallets']) or !is_array($wallets['wallets'])) {
            $this->logger->error("No 'Wallets' data received!");
            return [];
        }

        // Get financialMovements via API
        $financialMouvmemnts = $this->wsseAuth->getContent($baseApiUrl .DIRECTORY_SEPARATOR. 'financialMovements/');
        $wallets_to_return = [];
        //echo "<pre>";var_dump($financialMouvmemnts);exit;
        foreach ($wallets['wallets'] as $walet) {           
            // bookingAmount(value, currency) object
            $bookingAmount = new \stdClass();
            $bookingAmount->value = $walet['bookingAmount']['value'];
            $bookingAmount->currency = $walet['bookingAmount']['currency'];
            // valueAmount(value, currency) object
            $valueAmount = new \stdClass();
            $valueAmount->value = $walet['valueAmount']['value'];
            $valueAmount->currency = $walet['valueAmount']['currency'];
            // dateLastFinancialMovement
            $date_last_movement = new \DateTime($walet['dateLastFinancialMovement']);
            // wallet object
            $wallet_obj = (new Wallet())
                ->setId($walet['id'])
                ->setTag($walet['tag'])
                ->setCurrency($walet['currency'])
                ->setBookingAmount($bookingAmount)
                ->setValueAmount($valueAmount)
                ->setDateLastFinancialMovement($date_last_movement);

            // get the wallet financial movement
            $walletFinancialMouvmemnts = $this->getFinancialMovmentsByWallet($walet['id'], $financialMouvmemnts);
            //  add wallet financial movement to current wallet
            foreach ($walletFinancialMouvmemnts as $walletFinancialMouvmemnt) {
                $wallet_obj->addFinancialMovements($walletFinancialMouvmemnt);
            }
            $wallets_to_return[] = $wallet_obj;
            unset($wallet_obj);
            unset($walletFinancialMouvmemnts);
        }
        // sorte the wallets by nbr of movements
        uasort(
            $wallets_to_return, function ($a, $b) {
                $v1 = count($a->getFinancialMovements());
                $v2 = count($b->getFinancialMovements());
                return $v2 - $v1;
            }
        );
        return $wallets_to_return;
    }
    /**
    * @return FinancialMovments[] : return an array of FinancialMovements objects
    */
    private function getFinancialMovmentsByWallet(string $wallet_id, array $financial_movements, $currencysRate = []): array
    {
        if (!isset($financial_movements['financialMovements']) or !is_array($financial_movements['financialMovements'])) {
            $this->logger->error("No 'financial movements' data received!");
            return [];
        }

        $financial_movements_by_wallet = [];
        // search all movement for current wallet
        foreach ($financial_movements['financialMovements'] as $movement) {
            if (isset($movement['walletId']) && strtolower($movement['walletId']) == strtolower($wallet_id)) {
                // populate amount object
                $amount = null;
                if (isset($movement['amount'])) {
                    $amount = new \stdClass();
                    $amount->value = $movement['amount']['value'];
                    $amount->currency = $movement['amount']['currency'];
                }
                // populate financial movement object
                $financial_movements_by_wallet[] = (new FinancialMovements())
                    ->setId($movement['id']??null)
                    ->setBookingDate(new \DateTime($movement['bookingDate']))
                    ->setValueDate(new \DateTime($movement['valueDate']))
                    ->setDescription($movement['description']??null)
                    ->setAmount($amount);
            }
        }
        return $financial_movements_by_wallet;
    }
}
