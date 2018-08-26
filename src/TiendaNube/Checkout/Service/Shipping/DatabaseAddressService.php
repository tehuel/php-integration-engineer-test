<?php

declare(strict_types=1);

namespace TiendaNube\Checkout\Service\Shipping;

use Psr\Log\LoggerInterface;
use TiendaNube\Checkout\Model\Address;

/**
 * Class DatabaseAddressService
 *
 * @package TiendaNube\Checkout\Service\Shipping
 */
class DatabaseAddressService implements AddressServiceInterface
{
    /**
     * The database connection link
     *
     * @var \PDO
     */
    private $connection;

    /**
     * The logger instance
     * @var LoggerInterface
     */
    private $logger;

    /**
     * DatabaseAddressService constructor.
     *
     * @param \PDO $pdo
     * @param LoggerInterface $logger
     */
    public function __construct(\PDO $pdo, LoggerInterface $logger)
    {
        $this->connection = $pdo;
        $this->logger = $logger;
    }

    /**
     * Get an address by its zipcode (CEP) from database
     *
     * @param string $zip
     * @return null|Address
     */
    public function getAddressByZip(string $zip):?Address
    {
        $this->logger->debug('Getting address for the zipcode [' . $zip . '] from database');

        try {
            // getting the address from database
            $stmt = $this->connection->prepare('SELECT * FROM `addresses` WHERE `zipcode` = ?');
            $stmt->execute([$zip]);

            // checking if the address exists
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetch(\PDO::FETCH_ASSOC);
                return $this->convertToAddressModel($result);
            } else {
                $this->logger->error('Address not found on Database');
                return null;
            }

        } catch (\PDOException $ex) {
            $this->logger->error('An error occurred at try to fetch the address from the database, exception with message was caught: ' . $ex->getMessage() );
            return null;
        }
    }

    private function convertToAddressModel(array $result) {
        return new Address(
            $result['address'],
            $result['neighborhood'],
            $result['city'],
            $result['state']
        );
    }

}
