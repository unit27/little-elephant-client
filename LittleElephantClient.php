<?php

// Include composer autoloader
include_once \dirname(__FILE__) . "/libs/autoload.php";

/**
 *
 * @author g.rombalski@unit27.net
 *
 */
class LittleElephantClient {

    /**
     * Your API key
     *
     * @var string
     */
    private $apiKey = null;

    /**
     *
     * @param string $apiKey
     */
    public function __construct(string $apiKey = null) {
        $this->apiKey = $apiKey;
    }

    /**
     * Scans your file
     *
     * @param string $pathToFile
     * @param string $scanType
     * @param string $apiKey
     * @return \LittleElephantClient\Model\DocumentInterface
     */
    public function scan(string $pathToFile, string $scanType = \LittleElephantClient\Types::AUTOMATIC, string $apiKey = null): ?\LittleElephantClient\Model\DocumentInterface {
        return (new \LittleElephantClient\Client(
            new \LittleElephantClient\Handler\Curl(),
            $apiKey ?? $this->apiKey,
            new \LittleElephantClient\File($pathToFile),
            $scanType
        ))->scan();
    }

    /**
     * Scan a file using preprocessor
     * This won't be done ad hoc, so we will return id of a file, which you can check up later using getResult method
     *
     * @see LittleElephantClient::getResult
     * @param string $pathToFile
     * @param string $scanType
     * @param string $apiKey
     * @return string
     */
    public function scanUsingPreprocessor(string $pathToFile, string $scanType = \LittleElephantClient\Types::AUTOMATIC, string $apiKey = null): ?string {
        return (new \LittleElephantClient\Client(
            new \LittleElephantClient\Handler\Curl(),
            $apiKey ?? $this->apiKey,
            new \LittleElephantClient\File($pathToFile),
            $scanType
        ))->scanWithPreprocessor();
    }

    /**
     * Gets your scan results
     *
     * @param string $fileId
     * @param string $apiKey
     * @return \LittleElephantClient\Model\DocumentInterface
     */
    public function getResult(string $fileId, string $apiKey = null): ?\LittleElephantClient\Model\DocumentInterface {
        return (new \LittleElephantClient\Client(
            new \LittleElephantClient\Handler\Curl(),
            $apiKey ?? $this->apiKey
        ))->getResult($fileId);
    }

}