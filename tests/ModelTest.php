<?php
namespace LittleElephantClient\Tests;

/**
 * Mapping test
 *
 * @author g.rombalski@unit27.net
 *
 */
class ModelTest extends \PHPUnit\Framework\TestCase {

    /**
     * @test noResult
     */
    public function noResult(): void {
        $model = \LittleElephantClient\Model\DocumentFactory::create($this->createNoResult());
        $this->assertNull($model);
    }

    /**
     * @test automatic
     */
    public function automatic(): void {
        $model = \LittleElephantClient\Model\DocumentFactory::create($this->createAutomatic());
        $this->assertNull($model);
    }

    /**
     * @test businessCard
     */
    public function businessCard(): void {
        $model = \LittleElephantClient\Model\DocumentFactory::create($this->createBusinessCard());
        $this->assertInstanceOf(\LittleElephantClient\Model\BusinessCard::class, $model);
        $this->checkGetters($model);
    }

    /**
     * @test invoice
     */
    public function invoice(): void {
        $model = \LittleElephantClient\Model\DocumentFactory::create($this->createInvoice());
        $this->assertInstanceOf(\LittleElephantClient\Model\Invoice::class, $model);
        $this->checkGetters($model);
    }

    /**
     * @test receipt
     */
    public function receipt(): void {
        $model = \LittleElephantClient\Model\DocumentFactory::create($this->createReceipt());
        $this->assertInstanceOf(\LittleElephantClient\Model\Receipt::class, $model);
        $this->checkGetters($model);
    }

    private function checkGetters(\LittleElephantClient\Model\DocumentInterface $model): void {
        foreach (\get_class_methods(\get_class($model)) as $method) {
            if (0 === \strpos($method, 'get')) { // getter
                $model->{$method}(); // just fire get method, typed return will throw exception if anything goes wrong
            }
        }
    }

    /**
     *
     * @return array
     */
    private function createAutomatic(): array {
        return [
            'type' => \LittleElephantClient\Types::AUTOMATIC,
            'anything' => 'anything'
        ];
    }

    /**
     *
     * @return array
     */
    private function createNoResult(): array {
        return [
            'type' => \LittleElephantClient\Types::INVOICE
        ];
    }

    /**
     *
     * @return array
     */
    private function createBusinessCard(): array {
        return [
            'type' => \LittleElephantClient\Types::BUSINESS_CARD,
            'fullName' => 'Jan Kowalski',
            'website' => 'www.test.pl',
            'telephones' => [
                '+48123123123'
            ],
            'email' => 'jan.kowalski@test.pl'
        ];
    }

    /**
     *
     * @return array
     */
    private function createInvoice(): array {
        return [
            'type' => \LittleElephantClient\Types::INVOICE,
            'buyerNip' => '321123-123-123',
            'sellerNip' => '123123-123-123',
            'totalPurchaseValue' => '12.34',
            'number' => 'FV123123/01/19',
            'items' => [
                [
                    'name' => 'Item 1',
                    'value' => '10.30'
                ],
                [
                    'name' => 'Item 2',
                    'value' => '2.04'
                ]
            ],
            'createdDate' => '2019-01-31 20:00:01',
            'addresses' => [
                [
                    'address' => 'ul. Testowa 1/2',
                    'city' => 'Testowo Małe',
                    'postalCode' => '99-012'
                ]
            ]
        ];
    }

    /**
     *
     * @return array
     */
    private function createReceipt(): array {
        return [
            'type' => \LittleElephantClient\Types::RECEIPT,
            'deviceNumber' => '123123123',
            'nip' => '123123-123-123',
            'value' => '12.34',
            'createdDate' => '2019-01-31 20:00:01',
            'companyName' => 'Company Name Test',
            'postalCode' => '00-001',
            'address' => 'ul. Testowa 1/2 99-012 Testowo Małe',
            'items' => [
                [
                    'name' => 'Item 1',
                    'value' => '10.30'
                ],
                [
                    'name' => 'Item 2',
                    'value' => '2.04'
                ]
            ]
        ];
    }
}