<?php

namespace App\Middleware;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpClient\CurlHttpClient;
use App\Middleware\WsseAuthInterface;
/**
 * Class WsseAuth
 */
class WsseAuth implements WsseAuthInterface
{
    /**
     * @var ParameterBag
     */
    public $params;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * WsseAuth constructor.
     *
     * @param ParameterBagInterface $params
     * @param LoggerInterface       $logger
     */
    public function __construct(ParameterBagInterface $params, LoggerInterface $logger)
    {
        $this->params = $params;
        $this->logger = $logger;
    }
    /**
     * getContent : get the chosen Content via API
     *
     * @param  string $url API iBanFirst
     * @return array
     */
    public function getContent($url, $wss = true): ?array
    {
        try {
            $client = new CurlHttpClient();
            $option = [
                'verify_host' =>0,
                'verify_peer' => 0,
                'http_version' => 1.1,
                'max_redirects' => 10
            ];
            if ($option) {
                $option['headers'] = $this->attach();
            }

            $response = $client->request('GET', $url, $option);
            //var_dump($response->getStatusCode());exit;
            if ($response) {
                return $response->toArray();
            }
            return [];
        } catch (\Exception $e) {
            $this->logger->error("Error: no connexion to API server");
            return [];
        }
    }

    /**
     * Add WSSE auth headers to Request
     *
     * @throws \InvalidArgumentException
     */
    public function attach(): ?array
    {
        // get Parameters from symfony ParameterBag
        $parameter = $this->checkParameterStatus();
        $nonce = $this->generateNonce();
        $nonce64 = base64_encode($nonce);
        $createdAt = $this->generateCreatedDate();
        $digest = $this->generateDigest($nonce, $createdAt, $parameter["password"]);
        return [
            sprintf('X-WSSE: UsernameToken Username="%s", PasswordDigest="%s", Nonce="%s", Created="%s"', $parameter["username"], $digest, $nonce64, $createdAt),
            'Content-Type: application/json'
        ];
    }
    /**
     * checkParameterStatus : check  the parametre status
     *
     * @param  string $url API iBanFirst
     * @return array
     */
    public function checkParameterStatus(){
        try {
            $username = $this->params->get('API_USERNAME');
            $password = $this->params->get('API_PASSWORD');
        } catch (ParameterNotFoundException $e) {
            $this->logger->error("Error: please check API_USERNAME and API_PASSWORD values in .env");
            return [];
        }
        if (empty($username)) {
            $this->logger->error("Error: please check API_USERNAME value in .env");
            return [];
        }
        if (empty($password)) {
            $this->logger->error("Error: please check API_PASSWORD value in .env");
            return [];
        }
        return ["username"=>$username, "password"=>$password];
    }
    /**
     * generateDigest : generate the password digest
     * @param string $nonce
     * @param string $createdAt
     * @param string $password
     *
     * @return string
     */
    protected function generateDigest($nonce, $createdAt, $password)
    {
        return base64_encode(sha1($nonce . $createdAt . $password, true));
    }

    /**
     * Generate Nonce (number user once)
     *
     * @return string
     */
    private function generateNonce()
    {
        return substr(hash('sha512', uniqid(true)), 0 , 32);
    }
    /**
     * Relative datetime string
     * Doc: datetime.formats.relative
     *
     * @return string|null
     */
    private function generateCreatedDate()
    {
        return substr(gmdate('c'), 0, 19) . "Z";
    }
}
