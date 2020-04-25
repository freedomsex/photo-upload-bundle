<?php


namespace FreedomSex\PhotoUploadBundle\Services\Naming;


use FreedomSex\PhotoUploadBundle\Entity\FileInterface;

interface FileNamerInterface
{
    /**
     * Creates a name for the file being uploaded.
     *
     * @param FileInterface $entity  The object the upload is attached to
     *
     * @return string The file name
     */
    public function filename($entity): string;
}
