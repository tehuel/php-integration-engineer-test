<?php

namespace TiendaNube\Checkout\Model;

use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{
    public function testAddressToArray()
    {
        $addressArray = [
            'address' => 'Avenida da França',
            'neighborhood' => 'Comércio',
            'city' => 'Salvador',
            'state' => 'BA'
        ];

        // creates Address
        $address = new Address('Avenida da França', 'Comércio', 'Salvador', 'BA');

        // asserts
        $this->assertEquals($addressArray, $address->toArray());
    }


}
