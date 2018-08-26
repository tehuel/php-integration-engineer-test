<?php

declare(strict_types=1);

namespace TiendaNube\Checkout\Service\Shipping;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;
use TiendaNube\Checkout\Model\Address;

class ApiAddressService implements AddressServiceInterface
{

    /**
     * The (Guzzle) HTTP Client instance
     *
     * @var ClientInterface
     */
    private $client;

    /**
     * The logger instance
     *
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ApiAddressService constructor.
     *
     * @param ClientInterface $client
     * @param LoggerInterface $logger
     */
    public function __construct(ClientInterface $client, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    /**
     * Get an address by its zipcode (CEP) from the Address API
     *
     * @param string $zip
     * @return Address
     */
    public function getAddressByZip(string $zip): ?Address
    {
        // TODO: move this value to an ENV config value
        $uri = "/address/$zip";

        $this->logger->debug("Getting address for the zipcode [$zip] from Address API using URI [$uri]");

        try {
            $response = $this->client->request('GET', $uri);
            if($response->getStatusCode() == 200) {
                return $this->convertToAddressModel($response->getBody()->getContents());
            } else {
                $this->logger->debug("Address not found on Address API");
                return null;
            }
        }
        catch (GuzzleException $e) {
            $this->logger->error('An error occurred trying to fetch the address from the remote Address API, exception with message was caught: ' . $e->getMessage() );
            return null;
        }
    }

    /**
     * Converts the JSON $response to Address Model
     *
     * @param string $response
     * @return Address
     */
    private function convertToAddressModel(string $response): Address
    {
        $apiResponse = json_decode($response);

        return new Address(
            $apiResponse->address,
            $apiResponse->neighborhood,
            $apiResponse->city->name,
            $apiResponse->state->acronym
        );
    }
}