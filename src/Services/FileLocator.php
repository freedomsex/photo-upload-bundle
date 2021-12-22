<?php

namespace FreedomSex\PhotoUploadBundle\Services;

use FreedomSex\PhotoUploadBundle\Services\Naming\PathInverter;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class FileLocator
{

    private $destination;
    private $pathInverter;

    public function __construct(PathInverter $pathInverter, string $destination)
    {
        $this->destination = $destination;
        $this->pathInverter = $pathInverter;
    }

    public function destinationPath()
    {
        return $this->destination;
    }

    public function relativePath($fileName): string
    {
        return $this->pathInverter->fullPath($fileName);
    }

    public function absolutePath($fileName): string
    {
        $path = $this->relativePath($fileName);
        return $this->destinationPath().'/'.$path;
    }

    public function fileExists($fileName): ?string
    {
        $fullPath = $this->absolutePath($fileName);
        if (!file_exists($fullPath)) {
            return null;
        }
        return $fullPath;
    }

}