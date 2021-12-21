<?php

namespace FreedomSex\PhotoUploadBundle\Tests\Services;

use FreedomSex\PhotoUploadBundle\Services\FileLocator;
use FreedomSex\PhotoUploadBundle\Services\FilterService;
use FreedomSex\PhotoUploadBundle\Tests\BaseTestSetUp;

class FilterServiceTest extends BaseTestSetUp
{
    /** @var FilterService */
    private $object;

    public function setUp(): void
    {
        parent::setUp();
        $this->object = $this->get(FilterService::class);
        $this->name = '7487bc051_1080x1219_1640106918.txt';
        $this->path = '2021/12/21/74/7487bc051_1080x1219_1640106918.txt';
    }

    public function testResource()
    {

    }

    public function testClearCache()
    {

    }

    public function testPrepare()
    {
        $this->object->prepare($this->path);
    }

    public function testDumpImage()
    {

    }

    public function testFilter()
    {

    }

    public function testStored()
    {

    }

    public function testDefaultImage()
    {

    }

    public function testImage()
    {

    }

    public function testFilteredImage()
    {

    }

    public function testSaveCache()
    {

    }
}
