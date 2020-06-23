<?php


namespace FreedomSex\PhotoUploadBundle\Services\Naming;


use FreedomSex\PhotoUploadBundle\Entity\FileInterface;
use FreedomSex\PhotoUploadBundle\Services\Naming\PathNamerInterface;

class PathNamer implements PathNamerInterface
{
    const DATE_DIR_FORMAT = 'Y/m/d/';

    public function dateFilePath(int $time)
    {
        $time = $time ? $time : time();
        return date(self::DATE_DIR_FORMAT, $time);
    }

    public function nameFilePath($name)
    {
        $result = '/00/00';
        if ($name and strlen($name) > 10) {
            $sub[] = substr($name, 0, 2);
            $sub[] = substr($name, 2, 2);
            $result = implode('/', $sub);
        }
        return $result;
    }

    public function nameSubFolder($name)
    {
        $result = '00';
        if ($name and strlen($name) > 10) {
            $result = substr($name, 0, 2);
        }
        return $result;
    }

    public function generate(int $time, $name)
    {
        return $this->dateFilePath($time) . $this->nameSubFolder($name);
    }

    public function fullPath($entity): string
    {
        $name = $entity->getFile();
        $time = $entity->getAdded()->getTimestamp();
        return $this->generate($time, $name);
    }
}
