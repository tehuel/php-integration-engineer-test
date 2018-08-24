<?php

declare(strict_types=1);

namespace TiendaNube\Checkout\Service\Shipping;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
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


        try {
            $response = $this->client->request('GET', $uri);

            if($response->getStatusCode() == 200) {}
                $response = (string) $response->getBody();
                return \GuzzleHttp\json_decode($response, true);

        } catch (GuzzleException $e) {
            $this->logger->error(
                'An error occurred at try to fetch the address from the remote API, exception with message was caught: ' .
                $e->getMessage()
            );

        }

        return null;
    }
}