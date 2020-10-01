<?php

namespace App\Middleware;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpClient\CurlHttpClient;

/**
 * interface WsseAuth
 */
interface WsseAuthInterface
{
	public function getContent($url, $wss = true): ?array;

	public function attach(): ?array;
}