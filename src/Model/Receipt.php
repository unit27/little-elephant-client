<?php
namespace LittleElephantClient\Model;

class Receipt implements \LittleElephantClient\Model\DocumentInterface
{
    /**
     * Fiscal cash register device number
     *
     * @var string|null
     */
    private $deviceNumber = null;

    /**
     * NIP
     *
     * @var string|null
     */
    private $nip = null;

    /**
     * Receipt value / sum
     *
     * @var float|null
     */
    private $value = null;

    /**
     * Created date
     *
     * @var \DateTimeImmutable|null
     */
    private $createdDate = null;

    /**
     * Company name
     *
     * @var string|null
     */
    private $companyName = null;

    /**
     * Postal code (string, format: xx-xxx, where 'x' is a number)
     *
     * @var string|null
     */
    private $postalCode = null;

    /**
     * Address
     *
     * @var \LittleElephantClient\Model\Partial\Address
     */
    private $address = null;

    /**
     * Receipt items (array with \LittleElephantClient\Model\Partial\ReceiptItem elements)
     *
     * @var \LittleElephantClient\Model\Partial\ReceiptItem[]
     */
    private $items = [];

    /**
     * Additional data
     *
     * @var array
     */
    private $additionalInformation = [];

    /**
     * @return string|null
     */
    public function getDeviceNumber(): ?string
    {
        return $this->deviceNumber;
    }

    /**
     * @return string|null
     */
    public function getNip(): ?string
    {
        return $this->nip;
    }

    /**
     * @return float|null
     */
    public function getValue(): ?float
    {
        return $this->value;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getCreatedDate(): ?\DateTimeImmutable
    {
        return $this->createdDate;
    }

    /**
     * @return string|null
     */
    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @return \LittleElephantClient\Model\Partial\Address|null
     */
    public function getAddress(): ?\LittleElephantClient\Model\Partial\Address
    {
        return $this->address;
    }

    /**
     * @return \LittleElephantClient\Model\Partial\ReceiptItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return array
     */
    public function getAdditionalInformation(): array
    {
        return $this->additionalInformation;
    }

    /**
     * @param string $deviceNumber
     */
    public function setDeviceNumber(string $deviceNumber)
    {
        $this->deviceNumber = $deviceNumber;

        return $this;
    }

    /**
     * @param string $nip
     */
    public function setNip(string $nip)
    {
        $this->nip = $nip;

        return $this;
    }

    /**
     * @param float $value
     */
    public function setValue(float $value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @param \DateTimeImmutable $createdDate
     */
    public function setCreatedDate(string $createdDate)
    {
        $this->createdDate = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $createdDate);

        return $this;
    }

    /**
     * @param string $companyName
     */
    public function setCompanyName(string $companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * @param string $postalCode
     */
    public function setPostalCode(string $postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * @param array $address
     */
    public function setAddress(array $address)
    {
        $this->address = new \LittleElephantClient\Model\Partial\Address();
        foreach ($address as $key => $value) {
            $method = 'set' . \ucfirst($key);
            if (\method_exists($this->address, $method)) {
                $this->address->{$method}($value);
            }
        }

        return $this;
    }

    /**
     * @param array $items
     */
    public function setItems(array $items)
    {
        foreach ($items as $value) {
            $item = new \LittleElephantClient\Model\Partial\ReceiptItem();
            foreach ($value as $itemKey => $itemValue) {
                $method = 'set' . \ucfirst($itemKey);
                if (\method_exists($item, $method)) {
                    $item->{$method}($itemValue);
                }
            }
            $this->items[] = $item;
        }

        return $this;
    }

    /**
     * @param array $additionalInformation
     */
    public function setAdditionalInformation(array $additionalInformation)
    {
        $this->additionalInformation = $additionalInformation;

        return $this;
    }

}