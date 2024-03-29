<?php

namespace TiendaNube\Checkout\Service\Shipping;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use TiendaNube\Checkout\Model\Address;

class ApiAddressServiceTest extends TestCase
{
    public function testGetExistentAddressByZipcode()
    {
        // expected address Object
        $address = new Address('Avenida da França', 'Comércio', 'Salvador', 'BA');

        $headers = [
            "Content-Type" => "application/json",
            "Content-Length" => "308"
        ];
        $body = '{"altitude":7,"cep":"40010000","latitude":"-12.967192","longitude":"-38.5101976","address":"Avenida da França","neighborhood":"Comércio","city":{"ddd":71,"ibge":"2927408","name":"Salvador"},"state":{"acronym":"BA"}}';

        // queue http responses
        $mock = new MockHandler([
            new Response(200, $headers, $body),
        ]);
        $handler = HandlerStack::create($mock);

        // http client with mocked handler
        $client = new Client(['handler' => $handler]);

        // mocking logger
        $logger = $this->createMock(LoggerInterface::class);

        // creating service
        $service = new ApiAddressService($client, $logger);

        // testing
        $result = $service->getAddressByZip('40010000');

        // asserts
        $this->assertNotNull($result);
        $this->assertEquals($address,$result);
    }

    public function testGetNonexistentAddressByZipcode()
    {
        $headers = [
            "Content-Type" => "application/json",
            "Content-Length" => "0"
        ];

        // queue http responses
        $mock = new MockHandler([
            new Response(404, $headers),
        ]);
        $handler = HandlerStack::create($mock);

        // http client with mocked handler
        $client = new Client(['handler' => $handler]);

        // mocking logger
        $logger = $this->createMock(LoggerInterface::class);

        // creating service
        $service = new ApiAddressService($client, $logger);

        // testing
        $result = $service->getAddressByZip('40010001');

        // asserts
        $this->assertNull($result);
    }

    public function testGetAddressByZipcodeWithServerError()
    {
        $headers = [
            "Content-Type" => "application/json",
            "Content-Length" => "0"
        ];

        // queue http responses
        $mock = new MockHandler([
            new Response(500, $headers),
        ]);
        $handler = HandlerStack::create($mock);

        // http client with mocked handler
        $client = new Client(['handler' => $handler]);

        // mocking logger
        $logger = $this->createMock(LoggerInterface::class);

        // creating service
        $service = new ApiAddressService($client, $logger);

        // testing
        $result = $service->getAddressByZip('40010000');

        // asserts
        $this->assertNull($result);
    }

}
