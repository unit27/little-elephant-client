<?php
namespace LittleElephantClient;

class File {
    /**
     *
     * @var string
     */
    private $filePath = null;

    /**
     *
     * @var string
     */
    private $fileName = null;

    /**
     *
     * @var string
     */
    private $mimeType = null;

    /**
     *
     * @var int
     */
    private $fileSize = null;

    /**
     *
     * @param string $filepath
     * @param string $filename
     * @param string $mimeType
     * @throws \LittleElephantClient\Exception\FileException
     */
    public function __construct(string $filePath, ?string $fileName = null, ?string $mimeType = null) {
        // check if file exists
        try {
            $file = \fopen($filePath, 'r');
            \fclose($file);
        } catch (\Exception $e) {
            throw new \LittleElephantClient\Exception\FileException();
        }

        $this->filePath = $filePath;

        // optional parameters, if not set will be resolved on get
        $this->fileName = $fileName;
        $this->mimeType = $mimeType;
    }

    /**
     * Mime type
     *
     * @return string
     */
    public function getMimeType(): string {
        if (null === $this->mimeType) {
            $this->mimeType = $this->resolveMimeType();
        }

        return $this->mimeType;
    }

    /**
     * File name
     *
     * @return string
     */
    public function getFileName(): string {
        if (null === $this->fileName) {
            $this->fileName = $this->resolveFileName();
        }

        return $this->fileName;
    }

    /**
     * File size
     *
     * @return int
     */
    public function getFileSize(): int {
        return \filesize($this->filePath);
    }

    /**
     * File for cURL
     *
     * @return \CURLFile
     */
    public function getToSend() {
        return new \CURLFile($this->filePath, $this->getMimeType(), $this->getFileName());
    }

    /**
     * Resolve mime type
     *
     * @return string
     */
    private function resolveMimeType(): string {
        return \finfo_file(\finfo_open(FILEINFO_MIME_TYPE), $this->filePath);
    }

    /**
     * Resolve file name
     *
     * @return string
     */
    private function resolveFileName(): string {
        return \basename($this->filePath);
    }
}