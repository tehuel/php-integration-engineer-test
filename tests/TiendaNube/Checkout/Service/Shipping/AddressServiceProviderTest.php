<?php

declare(strict_types=1);

namespace TiendaNube\Checkout\Service\Shipping;

use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use TiendaNube\Checkout\Model\Store;

class AddressServiceProviderTest extends TestCase
{

    public function testGetAddressServiceForBetaStore()
    {
        // creates some mock dependencies
        $mockConnection = $this->createMock(\PDO::class);
        $mockClient = $this->createMock(ClientInterface::class);
        $mockLogger = $this->createMock(LoggerInterface::class);

        // creates mock beta Store
        $store = $this->createMock(Store::class);
        $store->method('isBetaTester')->willReturn(true);

        // Creates provider to test
        $provider = new AddressServiceProvider($mockConnection, $mockClient, $mockLogger);

        // Assert correct class is used
        $this->assertInstanceOf(ApiAddressService::class, $provider->getAddressServiceFor($store));

    }

    public function testGetAddressServiceForTraditionalStore()
    {
        // creates some mock dependencies
        $mockConnection = $this->createMock(\PDO::class);
        $mockClient = $this->createMock(ClientInterface::class);
        $mockLogger = $this->createMock(LoggerInterface::class);

        // creates mock traditional Store
        $store = $this->createMock(Store::class);
        $store->method('isBetaTester')->willReturn(false);

        // Creates provider to test
        $provider = new AddressServiceProvider($mockConnection, $mockClient, $mockLogger);

        // assert correct Class is used
        $this->assertInstanceOf(DatabaseAddressService::class, $provider->getAddressServiceFor($store));

    }
}
