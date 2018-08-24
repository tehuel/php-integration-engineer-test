<?php

declare(strict_types=1);

namespace TiendaNube\Checkout\Service\Shipping;

use GuzzleHttp\ClientInterface;
use Psr\Log\LoggerInterface;

class ApiAddressService
{

    private $client;
    private $logger;

    /**
     * ApiAddressService constructor.
     * @param ClientInterface $client
     * @param LoggerInterface $logger
     */
    public function __construct(ClientInterface $client, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    public function getAddressByZip(string $zip)
    {
        $uri = "/address/$zip";

        $response = $this->client->request('GET', $uri);

        $response = (string) $response->getBody();

        return json_decode($response, true);
    }
}