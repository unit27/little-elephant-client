<?php
namespace LittleElephantClient\Tests;

/**
 * Client class test
 *
 * @author g.rombalski@unit27.net
 *
 */
class ClientTest extends \PHPUnit\Framework\TestCase {
    public const TEST_FILE_TOKEN = 'test-file-token';

    /**
     * @test scanWithoutFile
     * @expectedException \LittleElephantClient\Exception\FileException
     */
    public function scanWithoutFile(): void {
        $client = new \LittleElephantClient\Client($this->createCurlMock(), 'testKey');
        $client->scan();
    }

    /**
     * @test scanUsingPreprocessorWithoutFile
     * @expectedException \LittleElephantClient\Exception\FileException
     */
    public function scanUsingPreprocessorWithoutFile(): void {
        $client = new \LittleElephantClient\Client($this->createCurlMock(), 'testKey');
        $client->scanWithPreprocessor();
    }

    /**
     * @test scanWithPreprocessor
     */
    public function scanWithPreprocessor(): void {
        $client = new \LittleElephantClient\Client($this->createCurlMock(), 'testKey', $this->createFile());

        $this->assertEquals(self::TEST_FILE_TOKEN, $client->scanWithPreprocessor());
    }

    /**
     * @test getResult
     */
    public function getResult(): void {
        $client = new \LittleElephantClient\Client($this->createCurlMockResult($this->createBusinessCard()), 'testKey');
        $model = $client->getResult(self::TEST_FILE_TOKEN);

        $this->assertInstanceOf(\LittleElephantClient\Model\DocumentInterface::class, $model);
    }

    /**
     * @test scan
     * @expectedException \LittleElephantClient\Exception\ConnectionException
     */
    public function scanWithServerSideException(): void {
        $client = new \LittleElephantClient\Client($this->createBadCurlMock(), 'testKey', $this->createFile());
        $client->scan();
    }

    /**
     * @test
     * @expectedException \LittleElephantClient\Exception\MappingException
     */
    public function scanNonExistentModel(): void {
        $client = new \LittleElephantClient\Client(
            $this->createCurlMockResult($this->createNonExistentModel()),
            'testKey',
            $this->createFile()
        );

        $client->scan();
    }

    /**
     * @test
     * @expectedException \LittleElephantClient\Exception\MappingException
     */
    public function scanInvalidModel(): void {
        $client = new \LittleElephantClient\Client(
            $this->createCurlMockResult($this->createInvalidModel()),
            'testKey',
            $this->createFile()
            );

        $client->scan();
    }

    /**
     * @test scan
     */
    public function scan(): void {
        $client = new \LittleElephantClient\Client(
            $this->createCurlMockResult($this->createBusinessCard()),
            'testKey',
            $this->createFile()
        );
        $model = $client->scan();
        $this->assertInstanceOf(\LittleElephantClient\Model\DocumentInterface::class, $model);

    }

    /**
     *
     * {@inheritDoc}
     * @see \PHPUnit\Framework\TestCase::tearDown()
     */
    public function tearDown(): void {
        \Mockery::close();
    }

    /**
     *
     * @return \LittleElephantClient\File
     */
    private function createFile(): \LittleElephantClient\File {
        return new \LittleElephantClient\File(__DIR__ . '/data/test_file.jpg');
    }

    /**
     *
     * @return \Mockery\MockInterface
     */
    private function createCurlMock(): \Mockery\MockInterface {
        $return = new \stdClass();
        $return->result = true;
        $return->data = self::TEST_FILE_TOKEN;

        $return = json_encode($return);

        $curl = \Mockery::mock(\LittleElephantClient\Handler\Curl::class);
        $curl->allows([
            'sendFile' => $return,
            'sendRequest' => $return
        ]);
        return $curl;
    }

    /**
     *
     * @param string $result
     * @return \Mockery\MockInterface
     */
    private function createCurlMockResult(array $result): \Mockery\MockInterface {
        $return = new \stdClass();
        $return->result = true;
        $return->data = $result;

        $return = json_encode($return);

        $curl = \Mockery::mock(\LittleElephantClient\Handler\Curl::class);
        $curl->allows([
            'sendFile' => $return,
            'sendRequest' => $return
        ]);
        return $curl;
    }

    /**
     *
     * @return \Mockery\MockInterface
     */
    private function createBadCurlMock(): \Mockery\MockInterface {
        $exception = new \stdClass();
        $exception->message = 'test-exception-message';

        $data = new \stdClass();
        $data->exception = $exception;

        $return = new \stdClass();
        $return->result = false;
        $return->data = $data;

        $return = json_encode($return);

        $curl = \Mockery::mock(\LittleElephantClient\Handler\Curl::class);
        $curl->allows([
            'sendFile' => $return,
            'sendRequest' => $return
        ]);
        return $curl;
    }

    private function createInvalidModel(): array {
        return [
            'fullName' => 'Jan Kowalski'
        ];
    }

    private function createNonExistentModel(): array {
        return [
            'type' => 'ASDF',
            'fullName' => 'Jan Kowalski'
        ];
    }

    private function createBusinessCard(): array {
        return [
            'type' => 'BUSINESS_CARD',
            'fullName' => 'Jan Kowalski',
            'website' => 'www.test.pl',
            'telephones' => [
                '+48123123123'
            ],
            'email' => 'jan.kowalski@test.pl'
        ];
    }
}