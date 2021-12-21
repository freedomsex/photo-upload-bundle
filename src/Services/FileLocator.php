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

    public function dest()
    {
        return $this->destination;
    }

    public function locate($fileName): string
    {
        $path = $this->pathInverter->fullPath($fileName);
        return $this->destination.'/'.$path;
    }

    public function exist($fileName): ?string
    {
        $fullPath = $this->locate($fileName);
        if (!file_exists($fullPath)) {
            return null;
        }
        return $fullPath;
    }

}