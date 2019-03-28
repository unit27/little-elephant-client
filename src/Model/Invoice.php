<?php
namespace LittleElephantClient\Model;

use LittleElephantClient;

class Invoice implements DocumentInterface
{
    public const TYPE = 'INVOICE';

    /**
     * Buyer number (NIP)
     *
     * @var string|null
     */
    private $buyerNip = null;

    /**
     * Seller number (NIP)
     *
     * @var string|null
     */
    private $sellerNip = null;

    /**
     * Total purchase value
     *
     * @var float|null
     */
    private $totalPurchaseValue = null;

    /**
     * Invoice number
     *
     * @var string|null
     */
    private $number = null;

    /**
     * Invoice items
     *
     * @var \LittleElephantClient\Model\Partial\InvoiceItem[]
     */
    private $items = [];

    /**
     * Addresses
     *
     * @var array
     */
    private $addresses = [];

    /**
     * Created date
     *
     * @var \DateTimeImmutable|null
     */
    private $createdDate = null;

    /**
     *
     * @return string|null
     */
    public function getBuyerNip(): ?string
    {
        return $this->buyerNip;
    }

    /**
     *
     * @return string|null
     */
    public function getSellerNip(): ?string
    {
        return $this->sellerNip;
    }

    /**
     *
     * @return float|null
     */
    public function getTotalPurchaseValue(): ?float
    {
        return $this->totalPurchaseValue;
    }

    /**
     *
     * @return string|null
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     *
     * @return \LittleElephantClient\Model\Partial\InvoiceItem[]
     */
    public function getItems(): ?array
    {
        return $this->items;
    }

    /**
     *
     * @return \LittleElephantClient\Model\Partial\Address[]
     */
    public function getAddresses(): ?array
    {
        return $this->addresses;
    }

    /**
     *
     * @return \DateTimeImmutable|null
     */
    public function getCreatedDate(): ?\DateTimeImmutable
    {
        return $this->createdDate;
    }

    /**
     *
     * @param string $buyerNip
     * @return \LittleElephantClient\Model\Invoice
     */
    public function setBuyerNip(string $buyerNip): \LittleElephantClient\Model\Invoice
    {
        $this->buyerNip = $buyerNip;

        return $this;
    }

    /**
     *
     * @param string $sellerNip
     * @return \LittleElephantClient\Model\Invoice
     */
    public function setSellerNip(string $sellerNip): \LittleElephantClient\Model\Invoice
    {
        $this->sellerNip = $sellerNip;

        return $this;
    }

    /**
     *
     * @param string $totalPurchaseValue
     * @return \LittleElephantClient\Model\Invoice
     */
    public function setTotalPurchaseValue(string $totalPurchaseValue): \LittleElephantClient\Model\Invoice
    {
        $this->totalPurchaseValue = \floatval($totalPurchaseValue);

        return $this;
    }

    /**
     *
     * @param string $number
     * @return \LittleElephantClient\Model\Invoice
     */
    public function setNumber(string $number): \LittleElephantClient\Model\Invoice
    {
        $this->number = $number;

        return $this;
    }

    /**
     *
     * @param array $items
     * @return \LittleElephantClient\Model\Invoice
     */
    public function setItems(array $items): \LittleElephantClient\Model\Invoice
    {
        foreach ($items as $value) {
            $item = new \LittleElephantClient\Model\Partial\InvoiceItem();
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
     *
     * @param array $addresses
     * @return \LittleElephantClient\Model\Invoice
     */
    public function setAddresses(array $addresses): \LittleElephantClient\Model\Invoice
    {
        $this->addresses = $addresses;

        return $this;
    }

    /**
     *
     * @param string $createdDate
     * @return \LittleElephantClient\Model\Invoice
     */
    public function setCreatedDate(string $createdDate): \LittleElephantClient\Model\Invoice
    {
        $this->createdDate = new \DateTimeImmutable($createdDate);

        return $this;
    }

    public function toArray(): array {
        $items = [];
        foreach ($this->items as $item) {
            $items[] = $item->toArray();
        }

        return [
            'buyerNip' => $this->buyerNip,
            'sellerNip' => $this->sellerNip,
            'totalPurchaseValue' => $this->totalPurchaseValue,
            'number' => $this->number,
            'items' => $items,
            'adresses' => $this->addresses,
            'createdDate' => $this->createdDate->format('Y-m-d H:i:s')
        ];
    }

}