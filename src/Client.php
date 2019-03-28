<?php

namespace LittleElephantClient;

/**
 *
 * @author g.rombalski@unit27.net
 *
 */
class Client {
    private const API_ROUTING = 'http://little-elephant.mordor/JSON/Api/Document/';
    private const API_SCAN_METHOD = 'scan';
    private const API_SCAN_USING_PREPROCESSOR_METHOD = 'scanWithPreprocessor';
    private const API_RESULT_METHOD = 'getResult';

    /**
     * Api key
     *
     * @var string
     */
    private $apiKey = null;

    /**
     *
     * @var \LittleElephantClient\File
     */
    private $file = null;

    /**
     *
     * @var \LittleElephantClient\Handler\Curl
     */
    private $handler = null;

    /**
     *
     * @var string
     */
    private $scanType = null;

    /**
     * Setting $scanType significantly lowers response time
     *
     * @param \LittleElephantClient\Handler\Curl $handler
     * @param string $apiKey
     * @param \LittleElephantClient\File $file
     * @param string $scanType
     */
    public function __construct(\LittleElephantClient\Handler\Curl $handler, string $apiKey, \LittleElephantClient\File $file = null, string $scanType = \LittleElephantClient\Types::AUTOMATIC) {
        if (! in_array($scanType, \LittleElephantClient\Types::$availableTypes))  {
            throw new \LittleElephantClient\Exception\MappingException();
        }

        $this->handler = $handler;
        $this->apiKey = $apiKey;
        $this->file = $file;
        $this->scanType = $scanType;
    }

    /**
     * Scan file using preprocessor,
     * returns file id that can be resolved using getResult method
     *
     * @see \LittleElephantClient\Client::getResult
     */
    public function scanWithPreprocessor(): string {
        return $this->sendFile($this->getScanUsingPreprocessorMethod());
    }

    /**
     * Scans a file and returns model as a response
     *
     * @return \LittleElephantClient\Model\DocumentInterface
     */
    public function scan(): \LittleElephantClient\Model\DocumentInterface {
        return $this->createModel((array) $this->sendFile($this->getScanMethod()));
    }

    /**
     * Get scanned data from file id
     *
     * @param string $fileId
     * @return \LittleElephantClient\Model\DocumentInterface
     */
    public function getResult(string $fileId): \LittleElephantClient\Model\DocumentInterface {
        return $this->createModel((array) $this->sendRequest($this->getResultMethod(), $fileId));
    }

    /**
     * Parse response and map it to model
     *
     * @param array $jsonData
     * @return \LittleElephantClient\Model\DocumentInterface
     */
    public function createModel(array $jsonData): \LittleElephantClient\Model\DocumentInterface {
        return \LittleElephantClient\Model\DocumentFactory::create($jsonData);
    }

    /**
     *
     * @return string
     */
    public function getApiKey(): string {
        return $this->apiKey;
    }

    /**
     *
     * @return ?\LittleElephantClient\File
     */
    private function getFile(): ?\LittleElephantClient\File {
        return $this->file;
    }

    /**
     * Send a file to LittleElephant and return parsed response
     *
     * @param string $url
     * @throws \LittleElephantClient\Exception\FileException
     * @throws \LittleElephantClient\Exception\ConnectionException
     * @return string|array
     */
    private function sendFile(string $url) {
        if (! ($this->getFile() instanceof \LittleElephantClient\File)) {
            throw new \LittleElephantClient\Exception\FileException('File doesn\'t exist');
        }

        $response = $this->handler->sendFile($url, $this->scanType, $this->getApiKey(), $this->getFile());

        return $this->parseResponse($response);
    }

    /**
     * Send file id to LittleElephant
     *
     * @param string $url
     * @param string $fileId
     * @throws \LittleElephantClient\Exception\ConnectionException
     * @return string|array
     */
    private function sendRequest(string $url, string $fileId): array {
        $response = $this->handler->sendRequest($url, $this->getApiKey(), $fileId);

        return (array) $this->parseResponse($response);
    }

    /**
     * Parse response, handle errors and return only data
     * Return is either token (string) or encoded json object (also string) or null if scan is still being analyzed
     *
     * @param string $response
     * @throws \LittleElephantClient\Exception\ConnectionException
     * @return string|array
     */
    private function parseResponse(string $response) {
        $json = \json_decode($response, true);

        if (true === $json['result']) {
            return $json['data'];
        }

        throw new \LittleElephantClient\Exception\ConnectionException($json['data']['exception']['message']);
    }

    /**
     * Url for scan
     *
     * @return string
     */
    private function getScanMethod(): string {
        return self::API_ROUTING . self::API_SCAN_METHOD;
    }

    /**
     * Url for scan with preprocessor
     *
     * @return string
     */
    private function getScanUsingPreprocessorMethod(): string {
        return self::API_ROUTING . self::API_SCAN_USING_PREPROCESSOR_METHOD;
    }

    /**
     * Url for results
     *
     * @return string
     */
    private function getResultMethod(): string {
        return self::API_ROUTING . self::API_RESULT_METHOD;
    }
}