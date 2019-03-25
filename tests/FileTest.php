<?php
namespace LittleElephantClient\Tests;

/**
 * File class test
 * @author imacmint
 *
 */
class FileTest extends \PHPUnit\Framework\TestCase {
    /**
     * @test
     */
    public function newFile(): void {
        $file = $this->createFile();
        $this->assertInstanceOf(\LittleElephantClient\File::class, $file);
    }

    /**
     * @test
     */
    public function getMimeType(): void {
        $file = $this->createFile();
        $this->assertEquals('image/jpeg', $file->getMimeType());
    }

    /**
     * @test
     */
    public function getFileName(): void {
        $file = $this->createFile();
        $this->assertEquals('test_file.jpg', $file->getFileName());
    }

    /**
     * @test
     */
    public function getFileSize(): void {
        $file = $this->createFile();
        $this->assertEquals(\filesize(__DIR__ . '/data/test_file.jpg'), $file->getFileSize());
    }

    /**
     * @test
     */
    public function createCurlFileToSend(): void {
        $file = $this->createFile();
        $this->assertInstanceOf(\CURLFile::class, $file->getToSend());
    }

    /**
     * @test
     * @expectedException \LittleElephantClient\Exception\FileException
     */
    public function createNonExistentFile(): void {
        new \LittleElephantClient\File(__DIR__ . '/data/non-existent-path-to-file.jpg');
    }

    /**
     *
     * @return \LittleElephantClient\File
     */
    private function createFile(): \LittleElephantClient\File {
        return new \LittleElephantClient\File(__DIR__ . '/data/test_file.jpg');
    }
}