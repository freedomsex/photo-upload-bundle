<?php

namespace FreedomSex\PhotoUploadBundle\Services;


use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;
use FreedomSex\PhotoUploadBundle\Services\Naming\FileNameParser;

class TrashService
{
    public function __construct(
        FileNameParser $nameParser,
        Filesystem $filesystem
    ) {
        $this->finder = new Finder();
        $this->nameParser = $nameParser;
        $this->filesystem = $filesystem;
    }

    public static function trashDir()
    {
        return date('Y-m-d');
    }

    public function trash($file, $path)
    {
        $trash = 'media/trash';
        $filename = pathinfo($file)['basename'];
        $dir = $trash . '/' . $this->trashDir() . '/' . $path;
        $name = $dir . '/' . $filename;

        $this->filesystem->mkdir($dir, 0755);
        $this->filesystem->rename($file, $name, true);
    }

    public function clear($path)
    {
        $directories = iterator_to_array($this->finder->directories()->in($path));
        foreach ($directories as $value) {
            @rmdir($value->getRealPath());
        }
    }

}
