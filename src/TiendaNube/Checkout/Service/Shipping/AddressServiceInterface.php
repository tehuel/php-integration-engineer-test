<?php

declare(strict_types=1);

namespace TiendaNube\Checkout\Service\Shipping;

use TiendaNube\Checkout\Model\Address;

/**
 * Interface AddressServiceInterface
 *
 * @package TiendaNube\Checkout\Service\Shipping
 */

interface AddressServiceInterface
{
    /**
     * Get an address by its zipcode (CEP)
     * The expected return format is an Address Model
     *
     * @param string $zip
     * @return Address
     */
    public function getAddressByZip(string $zip):?Address;
}