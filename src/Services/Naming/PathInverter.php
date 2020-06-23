<?php


namespace FreedomSex\PhotoUploadBundle\Services\Naming;


use FreedomSex\PhotoUploadBundle\Services\Naming\FileNameParser;
use FreedomSex\PhotoUploadBundle\Services\Naming\PathNamer;

class PathInverter
{
    public function __construct(FileNameParser $fileNameParser, PathNamer $pathNamer)
    {
        $this->parser = $fileNameParser;
        $this->pathNamer = $pathNamer;
    }

    public function fullPath($fileName)
    {
        $this->parser->parse($fileName);
        $time = $this->parser->added();
        $name = $this->parser->name();
        return $this->pathNamer->generate($time, $name)."/$fileName";
    }
}
