<?php


namespace FreedomSex\PhotoUploadBundle\Services;

use Doctrine\ORM\EntityManagerInterface;
use FreedomSex\PhotoUploadBundle\Entity\FileInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\PropertyMappingFactory;

class FileUploader
{
    public function __construct(
        FilterService $filterService,
        PropertyMappingFactory $propertyMapping,
        EntityManagerInterface $entityManager
    ) {
        $this->filterService = $filterService;
        $this->propertyMapping = $propertyMapping;
        $this->entityManager = $entityManager;

    }

    public function upload(UploadedFile $file, FileInterface $entity)
    {
        $realPath = $file->getRealPath();
        [$width, $height] = getimagesize($realPath);
        $extension = $file->guessExtension();

        $entity->setWidth($width);
        $entity->setHeight($height);
        $entity->setAdded(new \DateTime());
        $entity->setExtension($extension);
        $entity->setImageFile($file);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }

    public function relativeFilePath($entity)
    {
//        $mapping = $this->propertyMapping->
//        return
//            $this->propertyMapping->getUploadDir($entity).
//            $this->propertyMapping->getUploadName($entity);
    }
}
