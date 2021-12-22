<?php

namespace FreedomSex\PhotoUploadBundle\Tests\Services;

use FreedomSex\PhotoUploadBundle\Tests\BaseTestSetUp;
use FreedomSex\PhotoUploadBundle\Services\FileLocator;

class FileLocatorTest extends BaseTestSetUp
{
    /** @var FileLocator */
    private $object;

    public function setUp(): void
    {
        parent::setUp();
        $this->object = $this->get(FileLocator::class);
        $this->name = '7487bc051_1080x1219_1640106918.txt';
        $this->path = '2021/12/21/74/7487bc051_1080x1219_1640106918.txt';
    }

    public function testDestinationPath()
    {
        self::assertNotNull($this->object->destinationPath());
    }

    public function testAbsolutePath()
    {
        $path = $this->object->absolutePath($this->name);
        self::assertEquals($this->object->destinationPath().'/'.$this->path, $path);
    }

    public function testFileExist()
    {
        echo $this->object->absolutePath($this->name);
        self::assertNotNull($this->object->fileExists($this->name));
    }
}
