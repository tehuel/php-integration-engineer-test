<?php

declare(strict_types=1);

namespace TiendaNube\Checkout\Model;

/**
 * Class Address
 *
 * @package TiendaNube\Checkout\Model
 */
class Address
{

    /**
     * The Address' main address
     *
     * @var string
     */
    private $address;

    /**
     * The Address' neighborhood
     *
     * @var string
     */
    private $neighborhood;

    /**
     * The Address' city
     *
     * @var string
     */
    private $city;

    /**
     * The Address' state
     *
     * @var string
     */
    private $state;

    /**
     * Set the address' main address
     *
     * @param string $address
     */
    public function setAddress(string $address):void {
        $this->address = $address;
    }

    /**
     * Get the address' main address
     *
     * @return string
     */
    public function getAddress():string {
        return $this->address;
    }

    /**
     * Set the address' neighborhood
     *
     * @param string $neighborhood
     */
    public function setNeighborhood(string $neighborhood):void {
        $this->neighborhood = $neighborhood;
    }

    /**
     * Get the address' neighborhood
     *
     * @return string
     */
    public function getNeighborhood():string {
        return $this->neighborhood;
    }

    /**
     * Set the address' city
     *
     * @param string $city
     */
    public function setCity(string $city):void {
        $this->city = $city;
    }

    /**
     * Get the address' city
     *
     * @return string
     */
    public function getCity():string {
        return $this->city;
    }

    /**
     * Set the address' state
     *
     * @param string $state
     */
    public function setState(string $state):void {
        $this->state = $state;
    }

    /**
     * Get the address' state
     *
     * @return string
     */
    public function getState():string {
        return $this->state;
    }

}
