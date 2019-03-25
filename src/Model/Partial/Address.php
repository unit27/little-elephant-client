<?php
namespace LittleElephantClient\Model\Partial;

class Address
{
    /**
     *
     * @var string
     */
    private $address = null;

    /**
     *
     * @var string
     */
    private $city = null;

    /**
     *
     * @var string
     */
    private $postalCode = null;

    /**
     * @return string
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @param string $address
     */
    public function setAddress($address): \LittleElephantClient\Model\Partial\Address
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @param string $city
     */
    public function setCity($city): \LittleElephantClient\Model\Partial\Address
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @param string $postalCode
     */
    public function setPostalCode($postalCode): \LittleElephantClient\Model\Partial\Address
    {
        $this->postalCode = $postalCode;

        return $this;
    }

}