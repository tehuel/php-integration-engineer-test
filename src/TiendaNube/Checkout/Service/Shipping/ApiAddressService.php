<?php

declare(strict_types=1);

namespace TiendaNube\Checkout\Service\Shipping;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\TransferException;
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
            if($response->getStatusCode() == 200) {
                return $this->convertJSONResponseToArray($response->getBody()->getContents());
            }
        }
        catch (GuzzleException $e) {
            $this->logger->error('An error occurred trying to fetch the address from the remote Address API, exception with message was caught: ' . $e->getMessage() );//
        }
        return null;
    }

    /**
     * Converts the JSON response to Array
     * @param string $response
     * @return array
     */
    private function convertJSONResponseToArray(string $response): array {
        return \GuzzleHttp\json_decode($response, true);
    }
}