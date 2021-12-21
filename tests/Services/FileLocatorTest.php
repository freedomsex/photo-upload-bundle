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

    public function testDest()
    {
        self::assertNotNull($this->object->dest());
    }

    public function testLocate()
    {
        $path = $this->object->locate($this->name);
        self::assertEquals($this->object->dest().'/'.$this->path, $path);
    }

    public function testExist()
    {
        echo $this->object->locate($this->name);
        self::assertNotNull($this->object->exist($this->name));
    }
}
