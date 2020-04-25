<?php

namespace FreedomSex\PhotoUploadBundle\Services\Naming;


use FreedomSex\PhotoUploadBundle\Services\Naming\FileNamerInterface;

class FileNamer implements FileNamerInterface
{
    public function filename($entity): string
    {
        $prefix = $this->name($entity);
        $sizes = $entity->getWidth()."x".$entity->getHeight();
        $created = $entity->getAdded()->getTimestamp();
        return "{$prefix}_{$sizes}_{$created}";
    }

    public function name($entity)
    {
        $id = mt_rand(1111, 8888);
        $prefix = $entity->getAdded()->getTimestamp();
        return substr(md5($id . $prefix), 0, 9);
    }
}
