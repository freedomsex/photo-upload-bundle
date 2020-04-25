<?php


namespace FreedomSex\PhotoUploadBundle\Services\Naming\VichNaming;


use FreedomSex\PhotoUploadBundle\Entity\FileInterface;
use FreedomSex\PhotoUploadBundle\Services\Naming\FileNamerInterface;
use FreedomSex\PhotoUploadBundle\Services\Naming\PathNamerInterface;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;
use Vich\UploaderBundle\Naming\NamerInterface;

class UploadFileNamer implements NamerInterface, DirectoryNamerInterface
{
    public function __construct(
        FileNamerInterface $fileNamer,
        PathNamerInterface $pathNamer
    ) {
        $this->fileNamer = $fileNamer;
        $this->pathNamer = $pathNamer;
    }

    /**
     * Creates a name for the file being uploaded.
     *
     * @param FileInterface $entity  The object the upload is attached to
     * @param PropertyMapping $mapping The mapping to use to manipulate the given object
     *
     * @return string The file name
     */
    public function name($entity, PropertyMapping $mapping): string
    {
        $extension = $entity->getExtension();
        $filename = $this->fileNamer->filename($entity);
        return "$filename.$extension";
    }

    /**
     * Creates a directory name for the file being uploaded.
     *
     * @param FileInterface $entity  The object the upload is attached to
     * @param PropertyMapping $mapping The mapping to use to manipulate the given object
     *
     * @return string The directory name
     */
    public function directoryName($entity, PropertyMapping $mapping): string
    {
        return $this->pathNamer->fullPath($entity);
    }
}
