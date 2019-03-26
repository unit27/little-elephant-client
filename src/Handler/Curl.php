<?php
namespace LittleElephantClient\Handler;

/**
 * Simple handler for sending requests using cURL
 *
 * @author g.rombalski@unit27.net
 *
 */
class Curl
{
    /**
     * Response
     *
     * @var string
     */
    private $response = null;

    /**
     * Error
     *
     * @var string
     */
    private $error = null;

    /**
     * Send POST request with file
     * Returns string if success or false on error
     *
     * @param string $url
     * @param string $type
     * @param string $apiKey
     * @param \LittleElephantClient\File $file
     * @return string|bool
     */
    public function sendFile(string $url, string $type, string $apiKey, \LittleElephantClient\File $file): string {
        $handler = \curl_init();
        \curl_setopt_array($handler, [
            \CURLOPT_URL => $url,
            \CURLOPT_HEADER => false,
            \CURLOPT_POST => 1,
            \CURLOPT_HTTPHEADER => [
                'Content-Type:multipart/form-data',
                'Accept: application/json'
            ],
            \CURLOPT_POSTFIELDS => [
                'key' => $apiKey,
                'type' => $type,
                'file' => $file->getToSend()
            ],
            \CURLOPT_INFILESIZE => $file->getFileSize(),
            \CURLOPT_RETURNTRANSFER => true
        ]);

        return $this->handleResponse($handler);
    }

    /**
     * Send POST request with token
     * Returns string if success or false on error
     *
     * @param string $url
     * @param string $apiKey
     * @param string $fileId
     * @return string
     */
    public function sendRequest(string $url, string $apiKey, string $fileId): string {
        $handler = \curl_init();
        \curl_setopt_array($handler, [
            \CURLOPT_URL => $url,
            \CURLOPT_HEADER => false,
            \CURLOPT_POST => 1,
            \CURLOPT_HTTPHEADER => [
                'Accept: application/json'
            ],
            \CURLOPT_POSTFIELDS => [
                'key' => $apiKey,
                'token' => $fileId
            ],
            \CURLOPT_RETURNTRANSFER => true
        ]);

        return $this->handleResponse($handler);
    }

    /**
     * Shoot at api, save errors and return response
     *
     * @param resource $handler
     * @throws \LittleElephantClient\Exception\ConnectionException
     * @return string
     */
    private function handleResponse($handler) {
        $this->response = \curl_exec($handler);

        $this->error = \curl_error($handler);
        \curl_close($handler);

        if (false === $this->response) {
            throw new \LittleElephantClient\Exception\ConnectionException($this->error);
        }

        return $this->response;
    }
}