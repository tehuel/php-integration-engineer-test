<?php

namespace TiendaNube\Checkout\Model;

use PHPUnit\Framework\TestCase;

class StoreTest extends TestCase
{

    public function testIsNotBetaTesterByDefault()
    {
        // creates Store
        $store = new Store();

        // asserts
        $this->assertFalse($store->isBetaTester());
    }

    public function testIsBetaTester()
    {
        // creates Store
        $store = new Store();

        // asserts
        $this->assertFalse($store->isBetaTester());
        $store->enableBetaTesting();
        $this->assertTrue($store->isBetaTester());
    }
}
