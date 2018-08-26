<?php
/**
 * Created by PhpStorm.
 * User: tehuel
 * Date: 26/8/18
 * Time: 16:53
 */

namespace TiendaNube\Checkout\Service\Shipping;


use GuzzleHttp\ClientInterface;
use Psr\Log\LoggerInterface;
use TiendaNube\Checkout\Model\Store;

class AddressServiceProvider
{

    /**
     * The database connection link
     *
     * @var \PDO
     */
    private $connection;

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
     * AddressServiceProvider constructor.
     * TODO: this should be using dependency injection
     *
     * @param \PDO $connection
     * @param ClientInterface $client
     * @param LoggerInterface $logger
     */
    public function __construct(\PDO $connection, ClientInterface $client, LoggerInterface $logger)
    {
        $this->connection = $connection;
        $this->client = $client;
        $this->logger = $logger;
    }

    /**
     * Decides which AddressService to use for the store
     *
     * @param Store $store
     * @return ApiAddressService|DatabaseAddressService
     */
    public function getAddressServiceFor(Store $store): AddressServiceInterface {

        if ($store->isBetaTester()) {
            return new ApiAddressService($this->client, $this->logger);
        } else {
            return new DatabaseAddressService($this->connection, $this->logger);
        }

    }
}